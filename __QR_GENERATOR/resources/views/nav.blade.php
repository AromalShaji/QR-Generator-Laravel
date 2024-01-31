<nav class="navbar navbar-expand-lg navbar-light bg-dark" style="margin-left: 30px; margin-right: 30px; border-radius:30px; background: linear-gradient(left,black white);">
    <div class="container" style="padding-left: 30px; padding-right: 30px;">
        <a class="navbar-brand me-2" href="#">
            
        </a>

        <button data-mdb-collapse-init class="navbar-toggler" type="button" data-mdb-target="#navbarButtonsExample"
            aria-controls="navbarButtonsExample" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarButtonsExample">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#"><b>QR Generator</b></a>
                    </li>
                    <li class="nav-item">
                        <a data-mdb-ripple-init class="btn btn-warning me-3" href="{{ route('college') }}" role="button" @if(request()->routeIs('college')) style="display: none;" @endif>
                            College Vice
                        </a>
                        
                        <a data-mdb-ripple-init class="btn btn-warning me-3" href="{{ route('index') }}" role="button" @if(request()->routeIs('index')) style="display: none;" @endif>
                            Student Vice
                        </a>
                    </li>
                    
            </ul>

            <div class="d-flex align-items-center">
                    <a data-mdb-ripple-init class="btn btn-primary me-3" href="\logout" role="button">
                        QR Generator
                    </a>
            </div>
        </div>
    </div>
</nav>
<style>
    .container-padding {
        padding-left: 30px;
        padding-right: 30px;
        background-color: linear-gradient(left,black white);
    }
    
</style>
