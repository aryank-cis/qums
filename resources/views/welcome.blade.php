@extends('layouts.app')
@extends('layouts.appInclude')
<style>
    :root {
        --primary-color: #010712;
        --secondary-color: #818386;
        --bg-color: #FCFDFD;
        --button-color: #3B3636;
        --h1-color: #3F444C;
    }

    [data-theme="dark"] {
        --primary-color: #FCFDFD;
        --secondary-color: #818386;
        --bg-color: #010712;
        --button-color: #818386;
        --h1-color: #FCFDFD;
    }

    * {
        margin: 0;
        box-sizing: border-box;
        transition: all 0.3s ease-in-out;
    }

    .contact-container {
        display: flex;
        width: 100%;
        height: 100%;
        background: var(--bg-color);
        padding: 2%;
    }

    .left-col {
        width: 100vw !important;
        height: 100% !important;
        /* background-image: url("https://images.pexels.com/photos/931018/pexels-photo-931018.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500"); */
        background-image: url({{ asset('public/asset/logo/Query.png') }});

        background-size: contain;
        background-repeat: no-repeat;
    }

    .logo {
        width: 10rem !important;
        padding: 1.5rem !important;
    }

    .right-col {
        background: var(--bg-color);
        width: 50vw;
        height: 100vh;
        padding: 0rem 3.5rem;
    }

    h1,
    label,
    button,
    .description {
        font-family: 'Jost', sans-serif;
        font-weight: 400;
        letter-spacing: 0.1rem;
    }

    h1 {
        color: var(--h1-color) !important;
        text-transform: uppercase;
        font-size: 2.5rem;
        letter-spacing: 0.5rem;
        font-weight: 300;
    }

    p {
        color: var(--secondary-color);
        font-size: 0.9rem;
        letter-spacing: 0.01rem;
        width: 40vw;
        margin: 0.25rem 0;
    }

    label,
    .description {
        color: var(--secondary-color);
        text-transform: uppercase;
        font-size: 0.625rem;
    }

    form {
        width: 31.25rem;
        position: relative;
        margin-top: 2rem;
        padding: 1rem 0;
    }

    input,
    textarea,
    select,
    label {
        width: 40vw !important;
        display: block;
    }

    p,
    placeholder,
    input,
    textarea {
        font-family: 'Helvetica Neue', sans-serif;
    }

    input::placeholder,
    textarea::placeholder {
        color: var(--primary-color);
    }

    input,
    select,
    textarea {
        color: var(--primary-color) !important;
        font-weight: 500 !important;
        background: var(--bg-color) !important;
        border: none;
        border-bottom: 1px solid var(--secondary-color) !important;
        padding: 0.5rem 0 !important;
        margin-bottom: 1rem !important;
        outline: none;
    }

    textarea {
        resize: none;
    }

    button[type="submit"] {
        text-transform: uppercase !important;
        font-weight: 300 !important;
        background: var(--button-color) !important;
        color: var(--bg-color) !important;
        width: 10rem !important;
        height: 2.25rem !important;
        border: none !important;
        border-radius: 2px !important;
        outline: none !important;
        cursor: pointer;
    }

    input:hover,
    textarea:hover,
    button:hover,
    select:hover {
        opacity: 0.5;
    }

    button:active {
        opacity: 0.8;
    }

    /* Toggle Switch */

    .theme-switch-wrapper {
        display: flex;
        align-items: center;
        text-align: center;
        width: 160px;
        position: absolute;
        top: 0.5rem;
        right: 0;
    }

    .description {
        margin-left: 1.25rem;
    }

    .theme-switch {
        display: inline-block;
        height: 34px;
        position: relative;
        width: 60px;
    }

    .theme-switch input {
        display: none;
    }

    .slider {
        background-color: #ccc;
        bottom: 0;
        cursor: pointer;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        transition: .4s;
    }

    .slider:before {
        background-color: #fff;
        bottom: 0.25rem;
        content: "";
        width: 26px;
        height: 26px;
        left: 0.25rem;
        position: absolute;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: var(--button-color);
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    #error,
    #success-msg {
        width: 40vw;
        margin: 0.125rem 0;
        font-size: 0.75rem;
        text-transform: uppercase;
        font-family: 'Jost';
        color: var(--secondary-color);
    }
    }

    #success-msg {
        transition-delay: 3s;
    }

    @media only screen and (max-width: 950px) {
        .logo {
            width: 8rem;
        }

        h1 {
            font-size: 1.75rem;
        }

        p {
            font-size: 0.7rem;
        }

        input,
        textarea,
        button {
            font-size: 0.65rem;
        }

        .description {
            font-size: 0.3rem;
            margin-left: 0.4rem;
        }

        button {
            width: 7rem;
        }

        .theme-switch-wrapper {
            width: 120px;
        }

        .theme-switch {
            height: 28px;
            width: 50px;
        }

        .theme-switch input {
            display: none;
        }

        .slider:before {
            background-color: #fff;
            bottom: 0.25rem;
            content: "";
            width: 20px;
            height: 20px;
            left: 0.25rem;
            position: absolute;
            transition: .4s;
        }

        input:checked+.slider:before {
            transform: translateX(16px);
        }

        .slider.round {
            border-radius: 15px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

    }
</style>
@section('content')
    <div class="contact-container">
        <div class="left-col">
            <img class="logo" src="https://www.indonesia.travel/content/dam/indtravelrevamp/en/logo.png" />
        </div>
        <div class="right-col">
            {{-- <div class="theme-switch-wrapper">
                <label class="theme-switch" for="checkbox">
                    <input type="checkbox" id="checkbox" />
                    <div class="slider round"></div>
                </label>
                <div class="description">Dark Mode</div>
            </div> --}}
            <h1>Query Submission</h1>
            <p>Have questions or need assistance? Raise your query here, and let us help you plan the perfect experience!
            </p>
            <form id="contact-form" method="post" enctype="multipart/form-data" url="{{ route('submitQuery') }}">
                <label for="name">Full name</label>
                <input type="text" id="name" name="name" placeholder="Your Full Name" required>
                <label for="email" class="mt-2">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Your Email Address" required>
                <label for="departments" class="mt-2">Query Type</label>
                <select name="departments" id="departments" data-url="{{ route('QueryMember') }} ">
                    <option value="{{ null }}">Choose one</option>
                    @if ($departments)
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    @endif
                </select>
                <label for="QueryMember" class="mt-2">Query Member</label>
                <select name="query_for" id="QueryMember">
                    <option value="{{ null }}">Choose one</option>
                </select>
                <label for="message" class="mt-2">Message</label>
                <textarea rows="6" placeholder="Your Message" id="message" name="message" required></textarea>
                <div class="mt-1">
                    @include('components.loader')
                    <button type="submit" id="submit" name="submit">Send</button>
                </div>
            </form>
            <div id="error"></div>
            <div id="success-msg"></div>
        </div>
    </div>
@endsection
