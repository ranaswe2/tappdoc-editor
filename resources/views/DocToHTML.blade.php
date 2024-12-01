<!-- resources/views/DocToXML.blade.php -->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>MS Word in Laravel</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  

    <style>
      .square-input {
        width: 360px;
        height: 200px;
      }
    </style>
  </head>
  <body>


    <div class="container">
      <h2 align="center">Download HTML File From Doc/x</h2><br/>
      
      <form action="/convert-doc-to-html" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="doc_file" required>
        <button type="submit">Download</button>
      </form>
      
      <h2 align="center">View HTML Page From Doc/x</h2><br/>

      <form action="/view-doc-to-html" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="doc_file" required>
        <button type="submit">View</button>
      </form>
    </div>


    
  </body>
</html>
