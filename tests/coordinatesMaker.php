<?php

require_once '../src/Mind.php';

$Mind = new Mind();

?>

<form class="example1" action="">
    
    <h5>INPUT TEXT</h5>
    <input type="text" id="my-coordinates">
    
    <br>
    
    <h5>TEXTAREA</h5>
    <textarea id="my-coordinates"></textarea>
    
    <br>
    
    <h5>SPAN</h5>
    <span id="my-coordinates"></span>
    
    <br>
    
    <h5>i</h5>
    <i id="my-coordinates"></i>
    
    <br>
    
    <h5>CHECKBOX</h5>
    <input type="checkbox" id="my-coordinates">
    <label for="my-coordinates"> I have a bike</label>
    
    <br>

    <h5>OPTION</h5>
    <select>
        <option id="my-coordinates">My Coordinate</option>
        <option>Nothing</option>
    </select>
    
    <br>

    <h5>MULTI OPTION</h5>
    <select name="fruit" multiple>
        <option value ="none">Nothing</option>
        <option value ="guava" id="my-coordinates">Guava</option>
        <option value ="lychee">Lychee</option>
        <option value ="papaya">Papaya</option>
        <option value ="watermelon">Watermelon</option>
    </select> 

</form>

<?=$Mind->coordinatesMaker('form.example1 #my-coordinates');?>

<br>

<h2>OR</h2>

<br>
<form action="">
    
    <h5>INPUT TEXT</h5>
    <input type="text" id="coordinates">
    
    <br>
    
    <h5>TEXTAREA</h5>
    <textarea id="coordinates"></textarea>
    
    <br>
    
    <h5>SPAN</h5>
    <span id="coordinates"></span>
    
    <br>
    
    <h5>i</h5>
    <i id="coordinates"></i>
    
    <br>
    
    <h5>CHECKBOX</h5>
    <input type="checkbox" id="coordinates">
    <label for="coordinates"> I have a bike</label>
    
    <br>

    <h5>OPTION</h5>
    <select>
        <option id="coordinates">My Coordinate</option>
        <option>Nothing</option>
    </select>
    
    <br>

    <h5>MULTI OPTION</h5>
    <select name="fruit" multiple>
        <option value ="none">Nothing</option>
        <option value ="guava" id="coordinates">Guava</option>
        <option value ="lychee">Lychee</option>
        <option value ="papaya">Papaya</option>
        <option value ="watermelon">Watermelon</option>
    </select> 

</form>
<?=$Mind->coordinatesMaker();?>
