<x-app-layout>
    <h1 class="font-semibold text-center">Contact Us</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container flex flex-col sm:flex-row">
        <div class="w-full flex flex-col items-center justify-center sm:w-1/2">
            <p>Work hours: Monday to Saturday 9:00am - 6:00pm EST</p>
            <p>Email Address: info@sermonstories.org, joe@sermonstories.org</p>
            <p>Telephone number: 239-234-7324</p>
        </div>


        <form class="flex flex-col w-full items-center justify-center sm:w-1/2" action="{{ route('contact.store') }}" method="POST">
            @csrf
            <label class="w-[350px] mt-3" for="first_name">First Name:</label>
            <input class="input input-bordered w-[350px]" type="text" id="first_name" name="first_name" required>
            @error('first_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <label class="w-[350px] mt-3" for="last_name">Last Name:</label>
            <input class="input input-bordered w-[350px]" type="text" id="last_name" name="last_name" required>
            @error('last_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <label class="w-[350px] mt-3" for="email">Email Address:</label>
            <input class="input input-bordered w-[350px]" type="email" id="email" name="email" required>
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <label class="w-[350px] mt-3" for="phone">Telephone number:</label>
            <input class="input input-bordered w-[350px]" type="tel" id="phone" name="phone" required>
            @error('phone')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <label class="w-[350px] mt-3" for="message">Message:</label>
            <textarea class="input input-bordered h-[80px] w-[350px]" id="message" name="message" required></textarea>
            @error('message')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <button class="ring btn btn-secondary mt-3 w-[350px]" type="submit">Submit</button>
        </form>
    </div>
</x-app-layout>
