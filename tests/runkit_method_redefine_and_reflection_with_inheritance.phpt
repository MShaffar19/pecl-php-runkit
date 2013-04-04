--TEST--
runkit_method_redefine() function with reflection and inheritance
--SKIPIF--
<?php if(!extension_loaded("runkit") || !RUNKIT_FEATURE_MANIPULATION) print "skip";
      if(version_compare(PHP_VERSION, '5.0.0', '<')) print "skip";
?>
--FILE--
<?php
class RunkitClass {
	function runkitMethod(RunkitClass $param) {
		echo "Runkit Method\n";
	}
}
class RunkitSubClass extends RunkitClass {}

$obj = new RunkitSubClass();

$reflClass = new ReflectionClass('RunkitSubClass');
$reflObject = new ReflectionObject($obj);
$reflMethod = new ReflectionMethod('RunkitSubClass', 'runkitMethod');

runkit_method_redefine('RunkitClass','runkitMethod', '', '');

var_dump($reflMethod);
$reflMethod->invoke($obj, $obj);
?>
--EXPECTF--
object(ReflectionMethod)#%d (2) {
  ["name"]=>
  string(28) "__method_removed_by_runkit__"
  ["class"]=>
  string(11) "RunkitClass"
}

Fatal error: RunkitClass::__method_removed_by_runkit__(): A method removed by runkit was somehow invoked in %s on line %d
