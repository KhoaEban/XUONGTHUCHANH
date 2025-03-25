@extends('layouts.master')

@section('content')

<style>
    .video-sidebar {
        width: 250px;
        background-color: #0A2647;
        color: white;
        padding: 10px 0;
        height: 100vh;
        position: fixed;
        left: 0;
        /* top: 0; */
        overflow-y: auto;
        height: calc(100vh - 56px);
        transition: all 0.3s ease-in-out;
    }

    .video-sidebar ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .video-sidebar li {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .video-sidebar .menu-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: white;
        text-decoration: none;
        padding: 12px 15px;
        transition: 0.3s;
    }

    .video-sidebar .menu-item:hover {
        background-color: #145DA0;
    }

    .video-sidebar .submenu {
        display: none;
        background: #1A3B5D;
        padding-left: 20px;
    }

    .video-sidebar .submenu li {
        padding: 8px 0;
    }

    .video-sidebar .submenu a {
        color: white;
        text-decoration: none;
        display: block;
        padding: 8px 10px;
        transition: 0.3s;
    }

    .video-sidebar .submenu a:hover {
        background: #367DBD;
    }

    .dropdown.active .submenu {
        display: block;
    }

    .dropdown .fa-chevron-down {
        transition: transform 0.3s;
    }

    .dropdown.active .fa-chevron-down {
        transform: rotate(180deg);
    }
</style>

<script>
    document.querySelectorAll('.dropdown').forEach(item => {
        item.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    });
</script>
