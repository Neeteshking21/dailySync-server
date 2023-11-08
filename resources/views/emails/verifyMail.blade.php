<section>
    <p>Hi {{$first_name}}, hope you're doing extremly well. Please click to Verifiy link below.</p>
    <a href="{{url('/api/verifyToken?token='.$token)}}">Verify account</a>
</section>