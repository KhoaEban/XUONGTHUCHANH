<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar bg-light border-end">
            <div class="d-flex flex-column vh-100">
                <div class="p-3 text-center border-bottom">
                    <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('image/images.png') }}"
                            class="img-fluid" /></a>
                </div>

        <div class="title item">
            <i class="dropdown icon"></i> Khóa học
        </div>
        <div class="content">
            <a class="item" href="inbox.html">Danh sách khóa học
            </a>
            {{-- <a class="item" href="mail.html">Mailbox
            </a>
            <a class="item" href="chat.html">Chat
            </a>
            <a class="item" href="contacts.html">Contacts
            </a>
            <a class="item" href="photoeditor.html">Photo Editor
            </a>
            <a class="item" href="calendar.html">Calendar
            </a>
            <a class="item" href="filter.html">Filter
            </a>
            <a class="item" href="todo.html">Todo
            </a> --}}
        </div>
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
        </div>

        <a class="item">
            <b>Components</b>
        </a>

        <div class="title item">
            <i class="dropdown icon"></i> UI-Kit
        </div>
        <div class="content">
            <a class="item" href="accordion.html">Accordion
            </a>
            <a class="item" href="breadcrumb.html">Breadcrumb
            </a>
            <a class="item" href="button.html">Button
            </a>
            <a class="item" href="divider.html">Divider
            </a>
            <a class="item" href="dropdown.html">Dropdown
            </a>
            <a class="item" href="flag.html">Flag
            </a>
            <a class="item" href="icon.html">Icon
            </a>
            <a class="item" href="image.html">Image
            </a>
            <a class="item" href="label.html">Label
            </a>
            <a class="item" href="list.html">List
            </a>
            <a class="item" href="modal.html">Modal
            </a>
            <a class="item" href="notification.html">Notification
            </a>
            <a class="item" href="alert.html">Alert
            </a>

            <a class="item" href="progress.html">Progress
            </a>
            <a class="item" href="range-v1.html">Range Semantic
            </a>
            <a class="item" href="range-v2.html">Range Material
            </a>
            <a class="item" href="rating.html">Rating
            </a>
            <a class="item" href="tab.html">Tab
            </a>
            <a class="item" href="tooltip.html">Tooltip
            </a>
            <a class="item" href="transition.html">Transition
            </a>
        </div>

        <div class="title item">
            <i class="dropdown icon"></i> Pages
        </div>
        <div class="content">
            <a class="item" href="profile.html">Profile
            </a>

            <a class="item" href="settings.html">Settings
            </a>

            <a class="item" href="blank.html">Blank
            </a>
            <a class="item" href="signin.html">Sign In
            </a>
            <a class="item" href="signup.html">Sign Up
            </a>
            <a class="item" href="forgotpassword.html">Forgot Password
            </a>
            <a class="item" href="lockme.html">Lock Me Screen
            </a>
            <a class="item" href="404.html">Error 404
            </a>
            <a class="item" href="comingsoon.html">Coming Soon
            </a>
        </div>

        <div class="title item">
            <i class="dropdown icon"></i> Form
        </div>
        <div class="content">
            <a class="item" href="formelements.html">Form Element
            </a>
            <a class="item" href="input.html">Input
            </a>
            <a class="item" href="formvalidation.html">Form Validation
            </a>

            <a class="item" href="editor.html">Html Editor
            </a>
        </div>

        <div class="title item">
            <i class="dropdown icon"></i> Tables
        </div>
        <div class="content">
            <a class="item" href="table.html">Static Table
            </a>
            <a class="item" href="datatable.html">Datatable
            </a>
            <a class="item" href="editable.html">Editable
            </a>
        </div>
        <div class="title item">
            <i class="dropdown icon"></i> Chart
        </div>
        <div class="content">
            <a class="item" href="chart.html">Charts 1
            </a>
            <a class="item" href="chart-2.html">Charts 2
            </a>
            <a class="item" href="chart-3.html">Charts 3
            </a>
        </div>
    </div>
    <div class="ui dropdown item displaynone">
        <z>Dashboard</z>
        <i class="icon demo-icon heart icon-heart"></i>

        <div class="menu">
            <div class="header">
                Dashboard
            </div>
        </div>

        <!-- Content -->
        <div class="col-md-10 content-wrapper py-5">
            @yield('content')
        </div>
    </div>
</div>

<script>
    // document.addEventListener("DOMContentLoaded", function() {
    //     document.querySelectorAll(".collapsed").forEach(item => {
    //         item.addEventListener("click", function() {
    //             this.nextElementSibling.classList.toggle("show");
    //             this.querySelector("i.fas.fa-chevron-down").classList.toggle("rotate");

    //             if (this.nextElementSibling.classList.contains("show")) {
    //                 this.style.color = "#007bff";
    //             } else {
    //                 this.style.color = "#000";
    //             }
    //         });
    //     });
    // });
</script>

<style>
    .sidebar {
        width: 260px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        overflow: auto;
    }

    .content-wrapper {
        margin-left: 260px;
        width: calc(100% - 260px);
    }

    .nav-link {
        padding: 10px 15px;
    }

    .rotate {
        transform: rotate(180deg);
        transition: 0.3s;
    }
</style>
