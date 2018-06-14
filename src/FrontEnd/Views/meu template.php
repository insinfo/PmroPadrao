  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">  
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" ></script>
 <style>

      html,body,.container {
    height:100%;
}
.container {
    display:table;
    width: 100%;
    margin-top: -50px;
    padding: 50px 0 0 0; /*set left/right padding according to needs*/
    box-sizing: border-box;
}
header {
    background: green;
    height: 50px;
}

.row {
    height: 100%;
    display: table-row;
}

.row .cell {
  display: table-cell;
  float: none;
}

.cell-1 {   
    background: pink;
  width: 25%;
}
.cell-2 {
    background: yellow; 
  width: 75%;
}

</style>
<header>Header</header>
<div class="container">
    <div class="row">
        <div class="cell cell-1">Navigation</div>
        <div class="cell cell-2">Content</div>
    </div>
</div>