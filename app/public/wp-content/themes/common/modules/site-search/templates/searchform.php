<div class="search-bar">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <div class="close-button"></div>
                    <input type="search" class="search-input" placeholder="SØKE SYSLA" value="<?php echo get_search_query(); ?>" name="s" />
                </form>

                <div class="search-result">
                    <div class="search-result-title">
                        <span class="most-read-title">Mest sett</span>
                        <span class="search-title">Alle resultator</span>
                    </div>

                    <div class="search-result-content">
                        <ul class="search-result-list"></ul>

                        <a href="#" class="see-all">See all results &raquo;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
