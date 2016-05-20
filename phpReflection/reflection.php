<?php namespace Facebook\Entities;
 
class UUID {}
abstract class Entity {}
interface Friendable {}
interface Likeable {}
interface Postable {}
 
class User extends Entity implements Friendable, Likeable, Postable {
  public function __construct($name, UUID $uuid){}
  public function like(Likebable $entity){}
  public function friend(User $user){}
  public function post(Post $post){}
}
 
$reflection = new \ReflectionClass(new User('Philip Brown', new UUID(1234)));

//echo $reflection->getName().PHP_EOL;
//echo $reflection->getShortName().PHP_EOL;
//echo $reflection->getNamespaceName();

//$parent = $reflection->getParentClass();
//echo $parent->getName();

//$interfaces = $reflection->getInterfaceNames();
// 
//echo "<pre>";
//var_dump($interfaces);

//$methods = $reflection->getMethods();
//echo "<pre>";
//var_dump($methods);

$constructor = $reflection->getConstructor();
echo "<pre>";
var_dump($constructor);

#However, now that we’ve got an instance of ReflectionMethod, we can now get the dependencies of the class:
echo "<pre>";
var_dump($constructor->getParameters());

#This will return an array of ReflectionParameter objects. We can then use Reflection to get instances of the dependency objects:


