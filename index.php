<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>CanvasCoder</title>
  <link href="/css/bootstrap.css" rel="stylesheet">
  <link href="/css/bootstrap-responsive.css" rel="stylesheet">
  
  <link href="/css/canvas_coder.css" rel="stylesheet">
  
  <script src="/js/jquery-1.8.2.min.js"></script>
  <script src="/js/bootstrap.js"></script>

  <!-- you don't need to keep this, but it's cool for stats! -->
  <meta name="generator" content="nanoc 3.4.1"> 
</head>
<body>
  <div id="main">
    <div id="content">
      <h1>CanvasCoder</h1>
<div class="row">
  <div class="span6">
    <p class="left">Code</p>
    <form>
      <ul class="sizeform">
        <li class="left">
          <input type="text" class="sizetext" id="sizex" name="width" value=600 />
        </li>
        <li class="left">
          x
        </li>
        <li class="left">
          <input type="text" class="sizetext" id="sizey" name="height" value=500 />
        </li>
      </ul>
    </form>
    <textarea id="canvascode" class="code clear"></textarea>
    <p>ErrorMessage</p>
    <textarea id="errormessage" class="code clear"></textarea>
    <div>
      <a href="javascript:void(0)" id="exebtn" class="btn right">実行</a>
    </div>
  </div>
  <div class="span6">
    <div class="result">
      <p>Result</p>
      <canvas id="resultimage"></canvas>
    </div>
  </div>
</div>
<script src="/js/gin.js"></script>
<script>
$(function(){
  //テキストフィールド"sizex"
  $("#sizex").keyup(function () {
    var value = $("#sizex").val();
    $("#resultimage").css({width: value+"px"});
    $("#resultimage")[0].width = value;
  }).keyup();
 
  //テキストフィールド"sizey"
  $("#sizey").keyup(function () {
    var value = $("#sizey").val();
    $("#resultimage").css({height: value+"px"});
    $("#resultimage")[0].height = value;
  }).keyup();

  //canvascode syntax
  var exec = new Gin.Grammar({
    PList: / Program (Program)* /,
    Program: / Rect /,
    Rect: / [fillRect] Int[,]Int[,]Int[,]Int:fillrect/,
    Int: / $UINT:push /
  }, "PList", Gin.SPACE);

  //canvascode semantics
  var execAction = {
    _queue: [],
    shift: function(){
      return this._queue.shift();
    },
    push: function(v){
      this._queue.push(v);
    },
    fillrect: function(){
      var ctx = $("#resultimage")[0].getContext('2d');
      var x = this.shift();
      var y = this.shift();
      var width = this.shift();
      var height = this.shift();
      ctx.beginPath();
      ctx.fillRect(x, y, x+width, y+height);
    }
  };

  //ConvasCodeの実行
  $("#exebtn").click(function() {
    var input = $("#canvascode").val();
    exec.parse(input, execAction);
  });
});
</script>
    </div>
  </div>
</body>
</html>
