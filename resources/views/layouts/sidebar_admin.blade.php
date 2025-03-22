<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <div class="ui sidebar vertical left menu overlay visible"
                style="-webkit-transition-duration: 0.1s; overflow: visible !important;">
                <div class="item logo">
                    <img src="{{ asset('image/images.png') }}" />
                </div>
                <div class="ui accordion">
                    <a class="title item">Dashboard <i class="dropdown icon"></i>
                    </a>
                    <div class="content">
                        <a class="item" href="dashboard.html">Dashboard
                        </a>
                    </div>

                    <div class="title item">
                        <i class="dropdown icon"></i> Khóa học
                    </div>
                    <div class="content">
                        <a class="item" href="{{ route('admin.course.index') }}">Danh sách khóa học
                        </a>
                    </div>
                    <a class="item" href="{{ route('admin.category.index') }}">
                        <p>Quản lý Danh mục</p>
                    </a>
                    <a class="item" href="{{ route('admin.user.index') }}">
                        <p>Quản lý Người dùng</p>
                    </a>
                    {{-- <div class="title item">
                        <i class="dropdown icon"></i> Layouts
                    </div>
                    <div class="content">
                        <a class="item" href="sidebar.html">Sidebar
                        </a>
                        <a class="item" href="menu.html">Nav
                        </a>
                        <a class="item" href="animatedicon.html">Animated Icon
                        </a>
                        <a class="item" href="box.html">Box
                        </a>
                        <a class="item" href="cards.html">Cards
                        </a>
                        <a class="item" href="color.html">Colors
                        </a>
                        <a class="item" href="comment.html">Comment
                        </a>
                        <a class="item" href="embed.html">Embed
                        </a>
                        <a class="item" href="faq.html">Faq
                        </a>
                        <a class="item" href="feed.html">Feed
                        </a>
                        <a class="item" href="gallery.html">Gallery
                        </a>
                        <a class="item" href="grid.html">Grid
                        </a>
                        <a class="item" href="header.html">Header
                        </a>
                        <a class="item" href="timeline.html">Timeline
                        </a>
                        <a class="item" href="message.html">Message
                        </a>
                        <a class="item" href="price.html">Price
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="col-md-10 content-wrapper py-5">
            @yield('content')
        </div>
    </div>
</div>

<script>
    $(".openbtn").on("click", function() {
        $(".ui.sidebar").toggleClass("very thin icon");
        $(".asd").toggleClass("marginlefting");
        $(".sidebar z").toggleClass("displaynone");
        $(".ui.accordion").toggleClass("displaynone");
        $(".ui.dropdown.item").toggleClass("displayblock");

        $(".logo").find('img').toggle();

    })
    $(".ui.dropdown").dropdown({
        allowCategorySelection: true,
        transition: "fade up",
        context: 'sidebar',
        on: "hover"
    });

    $('.ui.accordion').accordion({
        selector: {

        }
    });
</script>
<style>
    .sidebar {
        width: 260px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        overflow: auto;
        background-color: #f8f8f8;
        border-right: 1px solid #ddd;
    }

    .content-wrapper {
        margin-left: 260px;
        width: calc(100% - 260px);
    }

    .marginlefting {
        margin-left: 60px !important;
    }

    .displaynone {
        display: none !important;
    }

    .displayblock {
        display: block !important;
    }

    .sidebar .item i {
        font-size: 24px;
        margin-top: -5px !important;
    }

    .logo {
        padding: 10px !important;
    }

    .logo img {
        width: 100% !important;
    }

    .title.item {
        padding: .92857143em 1.14285714em !important;
    }

    .dropdown .menu .header {
        padding-top: 3.9px !important;
        padding-bottom: 3.9px !important;
    }
</style>
