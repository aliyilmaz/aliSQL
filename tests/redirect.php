<?php

require_once '../src/Mind.php';

$Mind = new Mind();

// $Mind->redirect();
// $Mind->redirect('contact');
// $Mind->redirect('https://www.google.com');
// $Mind->redirect('', 5);
// $Mind->redirect('contact', 5);
// $Mind->redirect('https://www.google.com', 5);
$Mind->redirect('https://www.google.com', 20, '.example1 #redirect-time');

?>

<form class="example1" action="">
    
    <h5>INPUT TEXT</h5>
    <input type="text" id="redirect-time">
    
    <br>
    
    <h5>TEXTAREA</h5>
    <textarea id="redirect-time"></textarea>
    
    <br>
    
    <h5>SPAN</h5>
    <span id="redirect-time"></span>
    
    <br>
    
    <h5>i</h5>
    <i id="redirect-time"></i>
    
    <br>
    
    <h5>CHECKBOX</h5>
    <input type="checkbox" id="redirect-time">
    <label for="redirect-time"> I have a bike</label>
    
    <br>

    <h5>OPTION</h5>
    <select>
        <option id="redirect-time">Redirect time</option>
        <option>Nothing</option>
    </select>
    
    <br>

    <h5>MULTI OPTION</h5>
    <select name="fruit" multiple>
        <option value ="none">Nothing</option>
        <option value ="guava" id="redirect-time">Guava</option>
        <option value ="lychee">Lychee</option>
        <option value ="papaya">Papaya</option>
        <option value ="watermelon">Watermelon</option>
    </select> 

</form>