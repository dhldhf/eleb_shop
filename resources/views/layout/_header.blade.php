<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Brand</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="/">首页</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">你的需求都在这里 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('businesses.index') }}">商家列表</a></li>
                        <li><a href="{{ route('orders.index') }}">订单列表</a></li>
                        <li><a href="{{ route('categories.index') }}">食品分类</a></li>
                        <li><a href="{{ route('foods.index') }}">食品列表</a></li>
                        <li><a href="{{ route('activities.index') }}">活动列表</a></li>
                        <li><a href="{{ route('today') }}">订单销量统计</a></li>
                        <li><a href="{{ route('food_category.index') }}">菜品分类</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('events.index') }}">商家可报名活动</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-left" method="get" action="">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search" name="name">
                </div>
                <button type="submit" class="btn btn-default">搜索</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                @auth
                <li><a href="#">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></a>
                    <ul class="dropdown-menu">

                        {{--<li><a href="{{ route('businesses.show') }}">我的信息</a></li>--}}
                        {{--<li><a href="{{ route('foods.show') }}">我的菜品</a></li>--}}
                        <li role="separator" class="divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                <button class="btn btn-danger">注销</button>
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                            </form>
                        </li>
                        @endauth
                        @guest
                        <li><a href="{{ route('login') }}">登录</a></li>
                        @endguest
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
