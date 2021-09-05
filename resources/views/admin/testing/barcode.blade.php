<!DOCTYPE html>
<html>
<head>
  <title>Laravel 8 Barcode Generator</title>
</head>
<body>
<div class="container text-center">
  <div class="row">
    <div class="col-md-8 offset-md-2">
       <h1 class="mb-5">Laravel 8 Barcode Generator</h1>
       <div>{!! DNS1D::getBarcodeHTML('4445645656', 'C39') !!}</div></br>
       <div>{!! DNS1D::getBarcodeHTML('4445645656', 'POSTNET') !!}</div></br>
       <div>{!! DNS1D::getBarcodeHTML('4445645656', 'PHARMA') !!}</div></br>
       <div>{!! DNS2D::getBarcodeHTML('4445645656', 'QRCODE') !!}</div></br>
       <div>{!! DNS2D::getBarcodeHTML( url('/barcode'), 'QRCODE') !!}</div></br>
    </div>
  </div>
</div>
</body>
</html>