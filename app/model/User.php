<?php

    use Infonit\Database\Connection;

    class User{
        private $id;
        private $name;
        private $email;
        private $password;

        public function validateLogin(){
            $conn = Connection::getConn();
            $sql = 'SELECT * FROM users WHERE user_email = :email';
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email', $this->email);
            $stmt->execute();
            if($stmt->rowCount()){
                $result = $stmt->fetch();               
                if($result['user_password'] === $this->password){
                    $_SESSION['usr'] = array(
                        'id_user'   => $result['user_id'],
                        'name_user' => $result['user_name'],
                        'user_lvl'  => $result['user_lvl']
                    );
                    var_dump($_SESSION);
                    return true;
                }
            }
            throw new \Exception('Login Inválido');            
        }

        public function updateUser($array){           
            $key = "'";
            $conn = Connection::getConn();
            $sql = ' UPDATE `users` SET `user_name` = '. $key .  $array['name'] . $key. ', `user_email` =  '. $key . $array['email']. $key . ', `user_password` = '.$key.$array['password'].$key . 'WHERE user_id = '.$array['id'].'        ';
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()){
                header('Location: http://localhost/sistema/painel/usuarios');
                return true;
              
            }else{
                return 'Não foi possível atualizar o usuário';
            }
            
            
        }

        public function listUsers(){
            $conn = Connection::getConn();
            $sql = 'SELECT * FROM users';
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()){
                $result = $stmt->fetchAll();                             
                return $result;        
            }
            
        }

        public function editUser($id){
            $chave = $id[0];
            strval($chave);
            $conn = Connection::getConn();
            $sql = ' SELECT * FROM users where user_id ='.$chave.'';          
            $stmt = $conn->prepare($sql);
            $stmt->execute();           
            if($stmt->rowCount()){
                $result = $stmt->fetchAll();                                            
                return $result;
            }
            
        }

        public function registerUser($dados){
            $key = "'";
            $conn = Connection::getConn();           
            $sql = ' INSERT INTO `users` (`user_name`, `user_email`, `user_password`, `user_cpf`, `user_end`, `user_cidade`, `user_uf`, `user_lvl`) VALUES (' . $key . $dados['name'] . $key. ', ' . $key . $dados['email'] . $key. ', ' . $key . $dados['senha'] . $key. ' , ' . $key . $dados['cpf'] . $key. ' , ' . $key . $dados['end'] . $key. ' , ' . $key . $dados['cidade'] . $key. ' , ' . $key . $dados['uf'] . $key. ', ' . $key . $dados['lvl'] . $key. ')';
            var_dump($dados, $sql);
           
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()){
                $result = $stmt->fetchAll();                          
                header('Location: http://localhost/sistema/painel/usuarios');
            }  
        }

        public function deleteUser($id){
            $key = "'";
            $id = implode("','",$id);           
            $conn = Connection::getConn();           
            $sql = 'DELETE FROM `users` WHERE `users`.`user_id` = '. $id . '';           
           
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()){
                return true;
            }else{
                return 'Não foi possível deletar o usuário';
            }
        }


        // Setando os campos para serem manipulados fora da classe User
        public function setEmail($email){
            $this->email = $email;
        }
        public function setName($name){
            $this->name = $name;
        }
        public function setPassword($password){
            $this->password = $password;
        }

        public function setId($id){
            $this->id = $id;
        }

        // Criando os gets

        public function getEmail(){
            return $this->email;
        }

        public function getName(){
            return $this->name;
        }

        public function getPassword(){
            return $this->password;
        }
    }