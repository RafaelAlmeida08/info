<?php

    class CadastroController{

       public function index(){
       
       }

        public function usuarios(){
            if($_SESSION['usr']['user_lvl'] == 1){
            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader, [
                'cache' => '/path/to/compilation_cache',
                'auto_reload' => true,
            ]);            
            $template  = $twig->load('cadastro_usuarios.html');   
            $header    = $twig->load('includes/header.html');
            echo $header->render(["lvl" => $_SESSION['usr']['user_lvl']]);
            echo $template->render(); 
            }else{
                header('Location: http://localhost/sistema/noticias/gerais');    
            }
        
        }

        public function noticias(){

            if($_SESSION['usr']['user_lvl'] == 1){
                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader, [
                    'cache' => '/path/to/compilation_cache',
                    'auto_reload' => true,
                ]);            
                $template  = $twig->load('cadastro_noticias.html');       
                $header    = $twig->load('includes/header.html');
                echo $header->render(["lvl" => $_SESSION['usr']['user_lvl']]); 
                echo $template->render(); 
            }else{           
                header('Location: http://localhost/sistema/noticias/gerais');    
              
            }
        }

         

        public function registrarusuarios(){
            try{            
                $user = new User;              
                $array = $_POST;  
                $result = $user->registerUser($array);                   

            }catch(\Exception $e){
                return 'erro';               
            }
        }

      

        public function registrarnoticias(){
            try{            
                $noticia  = new Noticias;              
                $array = $_POST;
                $img   = $_FILES; 
                $noticia->registrarNoticia($array,$img);
               /* if($result = $user->registrarNoticia($array)){
                    header('Location: http://localhost/sistema/painel/noticias');
                }        */     

            }catch(\Exception $e){
                return 'erro';               
            }
        }
            
        

    }