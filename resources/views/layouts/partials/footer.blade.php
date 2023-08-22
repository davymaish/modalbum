<footer id="footer">
    <div class="footer-top">
        <div class="container footer-top">
            <div class="row">
                <div class="col-md-6 footer-col text-center">
                    <h4>{{ config('app.name') }}</h4>
                </div>
                <div class="col-md-6 footer-col text-center">
                    <p>Copyright &copy; {{ config('app.name') }}</p>
                    <ul class="list-inline">
                        <li><a href="{{ url('about') }}" title="About">About Us</a></li>
                        <li><a href="{{ url('about/terms') }}" title="Terms of Service">Terms</a></li>
                        <li><a href="{{ url('about/privacy-policy') }}" title="Privacy Policy">Privacy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>