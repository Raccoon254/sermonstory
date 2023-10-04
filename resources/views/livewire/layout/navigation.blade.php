<?php

use Livewire\Volt\Component;

new class extends Component
{
    public function logout(): void
    {
        auth()->guard('web')->logout();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirect('/', navigate: true);
    }
};
?>

<nav class="bg-white border-b border-gray-100">

    <header>

        <nav>
            <a href="/">Home</a>
            <a href="/about">About</a>
        </nav>

    </header>

    <style>
        header {
            display: flex;
            justify-content: space-between;
        }

        nav {
            padding-top: 5px;
            padding-bottom: 5px;
            width: 100%;
            display: flex;
            justify-content: center;
            --background: rgba(255, 255, 255, 0.7);
        }

        ul {
            position: relative;
            padding: 0;
            margin: 0;
            height: 3em;
            display: flex;
            justify-content: center;
            align-items: center;
            list-style: none;
            background: var(--background);
            background-size: contain;
            width: 100%;
        }

        li {
            position: relative;
            height: 100%;
        }

        li[aria-current='page']::before {
            --size: 6px;
            content: '';
            width: 0;
            height: 0;
            position: absolute;
            top: 0;
            left: calc(50% - var(--size));
            border: var(--size) solid transparent;
            border-top: var(--size) solid var(--color-theme-1);
        }

        nav a {
            display: flex;
            height: 100%;
            align-items: center;
            padding: 0 0.5rem;
            color: var(--color-text);
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            text-decoration: none;
            transition: color 0.2s linear;
        }

        a:hover {
            color: var(--color-theme-1);
        }
    </style>

</nav>
