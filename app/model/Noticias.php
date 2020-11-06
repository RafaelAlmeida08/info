<?php

    use Infonit\Database\Connection;

    class Noticias{     

        public function getNoticia($id){
            $id = implode("','",$id);            
            $conn = Connection::getConn();
            $sql = ' SELECT * FROM `noticias` WHERE noticia_id = ' . $id.'';        
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()){
                $result = $stmt->fetchAll();                                            
                return $result;              
            }else{
                return 'Não foi possível atualizar o usuário';
            }
        }

        public function listNoticias(){
            $conn = Connection::getConn();
            $sql = 'SELECT * FROM noticias ORDER BY noticia_id DESC';
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()){
                $result = $stmt->fetchAll();                                         
                return $result;        
            }
            
        }

        public function listSingle($id){
            $chave = $id[0];                   
            $conn = Connection::getConn();
            $sql = 'SELECT * FROM noticias where noticia_id ='.$chave.'';
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()){                
                $result = $stmt->fetchAll();                                         
                return $result;        
            }
            
        }

        public function registrarNoticia($dados, $img){
            $key = "'";
            if(isset($_FILES['img'])){                
                $extensao = strtolower(substr($img['img']['name'], -4 ));
                $nome     = md5(time()).$extensao;
                $local    = "assets/img/";  
                move_uploaded_file($_FILES['img']['tmp_name'], $local.$nome);               
              
            }   

            $now = new DateTime();
            $data = $now->format('d-m-Y');
          
           
            $conn = Connection::getConn();     
            $sql = ' INSERT INTO `noticias` (`noticia_titulo`, `noticia_data`, `noticia_resumo`, `noticia_img`, `noticia_conteudo`, `noticia_tipo`) VALUES (' . $key . $dados['titulo'] . $key. ', ' . $key .$data . $key. ', ' . $key . $dados['resumo'] . $key. ' , ' . $key . $nome . $key. ' ,  ' . $key . $dados['conteudo'] . $key. ' , ' . $key . $dados['tipo'] . $key. ')';
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()){
                $result = $stmt->fetchAll();                          
                header('Location: http://localhost/sistema/noticias/gerais');
            } 
        

        }
        
        public function updateNoticia($dados, $img){
            $key = "'";
            if(isset($_FILES['img'])){                
                $extensao = strtolower(substr($img['img']['name'], -4 ));
                $nome     = md5(time()).$extensao;
                $local    = "assets/img/";  
                move_uploaded_file($_FILES['img']['tmp_name'], $local.$nome); 
            }
            $conn = Connection::getConn();           
            $sql = ' UPDATE `noticias` SET `noticia_titulo` = '. $key .  $dados['titulo'] . $key. ', `noticia_resumo` =  '. $key . $dados['resumo']. $key . ', `noticia_tipo` = '.$key.$dados['tipo'].$key .', `noticia_img` = '.$key.$nome.$key . 'WHERE noticia_id = '.$dados['id'].''; 
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()){   
                return true;              
            }
            throw new \Exception('Notícia atualizada!');   
        }

        public function deleteNoticia($id){
            $id = implode("','",$id);            
            $conn = Connection::getConn();
            $sql = 'DELETE FROM `noticias` WHERE `noticias`.`noticia_id` = '. $id . '';     
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()){                                                    
                return true;            
            }else{
                return 'Não foi possível atualizar o usuário';
            }
        }

        public function listDestaques(){
                           
            $conn = Connection::getConn();
            //Pegando as notícias mais recentes com a tag de destaque 
            $sql = 'SELECT * FROM noticias where noticia_tipo = 1 ORDER BY noticia_id DESC ';
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()){                                
                $result = $stmt->fetchAll();                                         
                return $result;        
            }
            
        }
      
    }