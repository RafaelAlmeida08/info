<?php

    class NoticiasController{

        public function index($id){
            if($_SESSION['usr']['user_lvl'] == 1){
                try{            
                    $noticias = new Noticias;               
                    $data = $noticias->listSingle($id);               

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
                $template  = $twig->load('noticias.html');
                $header    = $twig->load('includes/header.html');
                echo $header->render(["lvl" => $_SESSION['usr']['user_lvl']]); 
                echo $template->render(["n"   => $dados_usuarios,"lvl" => $_SESSION['usr']['user_lvl']]); 
            }else{
                header('Location: http://localhost/sistema/noticias/gerais');    
            }
        }

        public function gerais(){
            try{            
                $noticia = new Noticias;               
                $data = $noticia->listNoticias();               

            }catch(\Exception $e){
                return 'erro';               
            }                    
            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader, [
            'cache' => '/path/to/compilation_cache',
            'auto_reload' => true,
            ]);    
           for( $i = 0 ; $i < count($data) ; $i++){
                $dados_noticias[] = $data[$i];
            }
            $template  = $twig->load('listnoticias.html');    
            $header    = $twig->load('includes/header.html');
            echo $header->render(["lvl" => $_SESSION['usr']['user_lvl']]); 
            echo $template->render(["n"   => $dados_noticias,"lvl" => $_SESSION['usr']['user_lvl']]); 
        }

        public function destaques(){

            try{            
                $noticia = new Noticias;               
                $data = $noticia->listDestaques();               

            }catch(\Exception $e){
                return 'erro';               
            }  

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader, [
            'cache' => '/path/to/compilation_cache',
            'auto_reload' => true,
            ]);    
            $template = $twig->load('listdestaques.html');

           for( $i = 0 ; $i <count($data)  ; $i++){
               if($i == 3){
                 break;   
                }            
                $dados_noticias[] = $data[$i];
            }

            $header    = $twig->load('includes/header.html');
            echo $header->render(["lvl" => $_SESSION['usr']['user_lvl']]); 
            echo $template->render(["n" => $dados_noticias]);           
        }
        
        public function editar($id){   
            if($_SESSION['usr']['user_lvl'] == 1){
                try{            
                    $noticia = new Noticias;               
                    $data = $noticia->getNoticia($id);               

                }catch(\Exception $e){
                    return 'erro';               
                }                    

                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader, [
                'cache' => '/path/to/compilation_cache',
                'auto_reload' => true,
                ]);    
               
            for( $i = 0 ; $i <count($data)  ; $i++){
                if($i == 3){
                    break;   
                    }            
                    $dados_noticias[] = $data[$i];
                }        
                $template = $twig->load('editar_noticias.html');
                $header    = $twig->load('includes/header.html');
                echo $header->render(["lvl" => $_SESSION['usr']['user_lvl']]); 
                echo $template->render(["n" => $dados_noticias]);   
            
                
            }else{
                header('Location: http://localhost/sistema/noticias/gerais');   
            }    
        }

        public function atualizar(){
            try{   
                $noticia = new Noticias;               
                if($data = $noticia->updateNoticia($_POST, $_FILES)){                                
                    header('Location: http://localhost/sistema/noticias/gerais/');                       
                }              
            }catch(\Exception $e){                
               return 'error';
            } 

           
        }

        public function delete($id){
            try{            
                $noticia = new Noticias;               
                if($data = $noticia->deleteNoticia($id)){
                    header('Location: http://localhost/sistema/noticias/gerais/');
                }               

            }catch(\Exception $e){
                return 'erro';               
            }            
        }

       
    

    }