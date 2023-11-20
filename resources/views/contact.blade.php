<x-app-layout>
    <h1 class="font-semibold text-center">Contact Us</h1>
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif
    <div class="container max-w-[800px] mx-auto sm:mt-6 flex flex-col sm:flex-row">
        <div class="w-full flex flex-col items-start justify-center gap-3 sm:w-1/2">
            <p><i class="fas fa-clock"></i> Work hours: Monday to Saturday 9:00am - 6:00pm EST</p>
            <p><i class="fas fa-envelope"></i> Email Address: info@sermonstories.org, joe@sermonstories.org</p>
            <p><i class="fas fa-phone"></i> Telephone number: 239-234-7324</p>
        </div>

        <form class="flex flex-col w-full items-center justify-center sm:w-1/2" action="{{ route('contact.store') }}" method="POST">
            @csrf
            <label class="w-[350px] mt-3" for="first_name"><i class="fas fa-user"></i> First Name:</label>
            <input class="input input-bordered w-[350px]" type="text" id="first_name" name="first_name" required>
            @error('first_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <label class="w-[350px] mt-3" for="last_name"><i class="fas fa-user"></i> Last Name:</label>
            <input class="input input-bordered w-[350px]" type="text" id="last_name" name="last_name" required>
            @error('last_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <label class="w-[350px] mt-3" for="email"><i class="fas fa-envelope"></i> Email Address:</label>
            <input class="input input-bordered w-[350px]" type="email" id="email" name="email" required>
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <label class="w-[350px] mt-3" for="phone"><i class="fas fa-phone"></i> Telephone number:</label>
            <input class="input input-bordered w-[350px]" type="tel" id="phone" name="phone" required>
            @error('phone')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <label class="w-[350px] mt-3" for="message"><i class="fas fa-comment"></i> Message:</label>
            <textarea class="input input-bordered h-[80px] w-[350px]" id="message" name="message" required></textarea>
            @error('message')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <button class="ring btn btn-secondary mt-3 w-[350px]" type="submit"><i class="fas fa-paper-plane"></i> Submit</button>
        </form>
    </div>
</x-app-layout>
