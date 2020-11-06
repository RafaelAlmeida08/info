<?php

    class TesteController{

        public function index(){    
            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader, [
                'cache' => '/path/to/compilation_cache',
                'auto_reload' => true,
            ]);            
            $template = $twig->load('painel.html');        
            $parameters['name_user'] = $_SESSION['usr']['name_user'];   
            return $template->render($parameters); 
        }

        public function usuarios(){                      
            try{            
                $user = new User;               
                $data = $user->listUsers();               

            }catch(\Exception $e){
                return 'erro';               
            }

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader, [
            'cache' => '/path/to/compilation_cache',
            'auto_reload' => true,
            ]);    
            $template = $twig->load('listusers.html');

            for( $i = 0 ; $i < count($data) ; $i++){
                $dados_usuarios[] = $data[$i];
            }

            echo $template->render([
                "n" => $dados_usuarios
                ]);         
        }

        public function editar($id){
            try{            
                $user = new User;               
                $data = $user->editUser($id);               

            }catch(\Exception $e){
                return 'erro';
                //$_SESSION['msg_error'] = array('msg' => $e->getMessage(), 'count' => 0);
                //header('Location: http://localhost/sistema/');
            }

            
            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader, [
            'cache' => '/path/to/compilation_cache',
            'auto_reload' => true,
            ]);    
            $template = $twig->load('editar_usuarios.html');

            for( $i = 0 ; $i < count($data) ; $i++){
                $dados_usuarios[] = $data[$i];
            }

            echo $template->render([
                "n" => $dados_usuarios
                ]);         

          
        }

        public function atualizarusuarios($id){
            try{            
                $data = new User;  
                $array = $_POST; 
                //var_dump($array);  
                /*$data->setId($_POST['id']);
                $data->setName($_POST['name']);
                $data->setEmail($_POST['email']);
                $data->setPassword($_POST['password']);
                $array = array($data);
                var_dump($array[0]); */
                $data->updateUser($array);   
                                       

            }catch(\Exception $e){
                return 'erro';               
            }
        }

        public function sair(){
            unset($_SESSION['usr']);
            session_destroy();
            header('Location: http://localhost/sistema/');
        }

        public function noticias(){
            return 'noticias';
        }

        public function registrousuarios(){
            return 'oi';
        }
       
    }