@extends('themes.default1.installer.layout.installer')
@section('content')
    <div class="wc-setup-content">
        <h1>Licence Agreement</h1>
        <form method="post">
            <p>PLEASE READ THIS SOFTWARE LICENSE AGREEMENT CAREFULLY BEFORE DOWNLOADING OR USING THE SOFTWARE. BY CLICKING ON THE "ACCEPT" BUTTON, OPENING THE PACKAGE, OR DOWNLOADING THE PRODUCT, YOU ARE CONSENTING TO BE BOUND BY THIS AGREEMENT. IF YOU DO NOT AGREE TO ALL OF THE TERMS OF THIS AGREEMENT, STOP THE INSTALLATION PROCESS AND EXIT.</p>
            
            <hr class="wc-setup-pages" cellspacing="0">
            
            <p class="wc-setup-actions step">
                <input type="checkbox" class="flat-red" id="accept" name="accept1"/> I accept the </label><a href="#" data-toggle="modal" data-target="#Edit"> Licence Agreement</a><label> <a href="step2.html" class="button button-primary">Continue</a>
            </p>
        </form>

    </div>
@stop