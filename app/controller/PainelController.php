<?php

    class PainelController{

        public function index(){    
            if($_SESSION['usr']['user_lvl'] == 1){      
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader, [
                    'cache' => '/path/to/compilation_cache',
                    'auto_reload' => true,
                ]);           
                $header    = $twig->load('includes/header.html'); 
                $template = $twig->load('painel.html');        
                $parameters['name_user'] = $_SESSION['usr']['name_user'];  
                echo $header->render(["lvl" => $_SESSION['usr']['user_lvl']]);  
                echo $template->render($parameters); 
            }
        }

        public function usuarios(){    
            if($_SESSION['usr']['user_lvl'] == 1){                  
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
                for( $i = 0 ; $i < count($data) ; $i++){
                    $dados_usuarios[] = $data[$i];
                }
                $template = $twig->load('listusers.html');
                $header    = $twig->load('includes/header.html');
                echo $header->render(["lvl" => $_SESSION['usr']['user_lvl']]); 
                echo $template->render([ "n" => $dados_usuarios]);
                }else{
                    header('Location: http://localhost/sistema/noticias/gerais');    
                }        
        }

        public function editar($id){
            if($_SESSION['usr']['user_lvl'] == 1){      
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
            for( $i = 0 ; $i < count($data) ; $i++){
                $dados_usuarios[] = $data[$i];
            }

            $template = $twig->load('editar_usuarios.html');
            $header    = $twig->load('includes/header.html');
            echo $header->render(["lvl" => $_SESSION['usr']['user_lvl']]); 
            echo $template->render([ "n" => $dados_usuarios]);     
            }else{
                header('Location: http://localhost/sistema/noticias/gerais');    
            }
          
        }

        public function atualizarusuarios($id){
            try{            
                $data = new User;  
                $array = $_POST;                
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

       

        public function excluir($id){
            try{            
                $data = new User;                                
                if($data->deleteUser($id)){
                    header('Location: http://localhost/sistema/painel/usuarios');
                }
                
            }catch(\Exception $e){
                return 'erro';               
            }
        }

       
    }