@extends('app')
@section('navigation')

    @include('includes.navigation')

@endsection

@section('content')
<div id="apikey-page" class="container">
    
    <div id="pageheader">
        <h1>Developers Documentation</h1>
    </div>

    <div class="content">
    	<div id="apiDocs">
	    	<h2>Build something beautiful</h2>
	    	<p>How to build an app using our API</p>
	    	<hr>

                <span id="apiKeyBox">www.laddder.be/api/v1/items/popular/YOURAPIKEYHERE</span>
                </br>
                <span id="apiKeyBox" class="apiurl">www.laddder.be/api/v1/projects/{id}/YOURAPIKEYHERE</span>
	    		<p>Documentation will follow</p>

    	</div>
		
		<div>
			<h2>Your personal API key</h2>
            <span id="apiKeyBox" class="apikey">{{$apikey}}</span>

            <button class="knp btn btn-default btnLaddderOrange" data-clipboard-action="copy" data-clipboard-target=".apikey">Copy</button>
		</div>

    </div>

</div>

 <p class="APIcounter">Number of API calls: {{ $apiCalls->calls }}</p>


            <script src="https://cdn.jsdelivr.net/clipboard.js/1.5.3/clipboard.min.js"></script>

            <script>

                var clipboard = new Clipboard('.knp');

            </script>
@endsection