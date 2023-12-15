<meta charset="utf-8">
  <title>ENDEVOUR</title>
  <link href="labels.css" rel="stylesheet" type="text/css">
  <style>
    body {
        margin: 0;
        padding: 0;
        border: 0;
        outline: 0;
        font-size: 100%;
        vertical-align: baseline;
        background: transparent;
        width: 6.000000cm;
        height: 2.200000cm;
        font-family: arial;
    }
    
    .page-break  {
        clear: left;
        margin: 0;
        padding: 0;
        border: 0;
        outline: 0;
        display:block;
        page-break-after:always;
    }

    p {
        padding: 0;
        margin: 0;
    } 

    .header {
        text-align: center;
        font-size: 0.85em;
    }
    .text-center {
        text-align: center;
    }

    .label {
        border: solid 1px #000;
        padding: 10px;
        border-radius: 5px;
    }

    .price {
        font-weight: bold;
        font-size: 1em;
    }

    .sub {
        font-size: 0.75em;
    }
  </style>

</head>

<body onload="printFunction();">
<div class="label">  
    <p class="header"><?php echo $item->name; ?></p>  
    <p class="sub text-center"><?php echo $item->description; ?></p>  
    <img width="100%" src="<?php echo base_url('/assets/images/barcode.png') ?>" /> 
     <p class="text-center price">&#8369;<?php echo $item->price; ?></p> 
</div> 
<div class="page-break"></div>

<script>
function printFunction() {
  var r = confirm("Do you want to open the print dialouge now?");
  if (r == true) {
    window.print();;
  } else {
    // closes alert
  }
}
</script>