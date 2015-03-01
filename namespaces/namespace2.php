<?php

/**
 * namespace2  description
 *
 * @author Kudryashov Sergey iden.82@gmail.com
 */

namespace namespaces\namespace2{
    
    // установил что неймспейсы вложенными быть не могут
   /* namespace namespaces\space4
    {
        class Myclass4{
        function __construct(){
                echo 'class 4 construct';
            }
        }
    }
    */
   // use namespaces\space4 as s4;
    
    class Myclass{
        protected $_global_myclass = null;
         
        public function __construct()
        {
            echo 'constructor  space 2 called';
            
            $this->setupGlobalMyclass();
            //$cc = new s4\Myclass4();            
        } 
        
        private function setupGlobalMyclass()
        {             
            $current_namespace = __NAMESPACE__;
            $this->_global_myclass = new \Myclass();
        }
        
        public function testMeth()
        {
            echo 'test meth space 2 called';
        }
    }

    $tt = new namespace\Myclass();
}
namespace namespaces\space3{

    class Myclass{
        public function __construct()
        {
            echo 'constructor  space 3 called';
        } 

        public function testMeth()
        {
            echo 'test meth space 3 called';
        }
    }
}

// global namespace
// global namespace
namespace {
    class Myclass{
        
        public function __construct()
        {
            echo 'constructor  space global called';
        } 

        public function testMeth()
        {
            echo 'test meth space global called';
        }
    }
}

?>
