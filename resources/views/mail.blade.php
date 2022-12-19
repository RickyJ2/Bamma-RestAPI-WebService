<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        <meta charset="UTF-8"> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Bamma Email Activation</title> 
    </head> 
    <body> 
        <h2>Terima kasih telah menggunakan layanan Sewa Kendaraan Bamma</h2>
        <p>Silahkan klik di bawah ini untuk {{ $content['body']}} </p> 
        <form action="{{ $content['link'] }}">
            <input type="submit" value="{{ $content['body'] }}" />
        </form>
    </body> 
</html>