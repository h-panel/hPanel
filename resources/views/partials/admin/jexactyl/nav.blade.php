@section('jexactyl::nav')
    <div class="row">
        <div class="col-xs-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li @if($activeTab === 'index')class="active"@endif><a href="{{ route('admin.index') }}">Home</a></li>
                    <li @if($activeTab === 'theme')class="active"@endif><a href="{{ route('admin.jexactyl.theme') }}">Appearance</a></li>
                    <li @if($activeTab === 'mail')class="active"@endif><a href="{{ route('admin.jexactyl.mail') }}">Mail</a></li>
                    <li @if($activeTab === 'advanced')class="active"@endif><a href="{{ route('admin.jexactyl.advanced') }}">Customization</a></li>
                    <li @if($activeTab === 'store')class="active"@endif><a href="{{ route('admin.jexactyl.store') }}">Resources & Coins</a></li>
                    <li @if($activeTab === 'registration')class="active"@endif><a href="{{ route('admin.jexactyl.registration') }}">Registration & OAuth2</a></li>
                    <li @if($activeTab === 'approvals')class="active"@endif><a href="{{ route('admin.jexactyl.approvals') }}">Approvals</a></li>
                    <li @if($activeTab === 'server')class="active"@endif><a href="{{ route('admin.jexactyl.server') }}">Server Settings & Renewal</a></li>
                    <li @if($activeTab === 'referrals')class="active"@endif><a href="{{ route('admin.jexactyl.referrals') }}">Referrals</a></li>
                    
                </ul>
            </div>
        </div>
    </div>
@endsection
