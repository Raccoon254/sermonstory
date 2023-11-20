<x-app-layout>
    <div class="container">
        <h1>Contact Us</h1>
        <p>Work hours: Monday to Saturday 9:00am - 6:00pm EST</p>
        <p>Email Address: info@sermonstories.org, joe@sermonstories.org</p>
        <p>Telephone number: 239-234-7324</p>

        <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Telephone number:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>

            <button type="submit">Submit</button>
        </form>
    </div>
</x-app-layout>
