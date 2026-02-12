<x-guest-layout>
    <form method="POST" action="{{ route('seller.register.store') }}">
        @csrf
        

        <h2 class="text-2xl font-bold mb-4 text-center">Seller Registration</h2>

        <div class="mb-4">
            <x-input-label for="name" value="Name" />
            <x-text-input id="name" name="name" type="text" required />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="mb-4">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" required />
            <x-input-error :messages="$errors->get('email')" />
        </div>
        <!--state-->
        <div class="mb-4">
    <x-input-label for="state" value="State" />

    <x-text-input
        id="state"
        name="state"
        type="text"
        list="stateList"
        placeholder="Type or select state"
        class="block w-full"
    />

    <datalist id="stateList">
        <option value="Tamil Nadu">
        
    </datalist>
</div>


        <!--district-->
         <div class="mb-4">
    <x-input-label for="district" value="District" />

    <x-text-input
        id="district"
        name="district"
        type="text"
        list="districtlist"
        placeholder="Type or select district"
        class="block w-full"
    />

    <datalist id="districtlist">
        <option value="Tirunelveli">
        <option value="Madurai">
        <option value="Trichy">
            <option value="Kanyakumari">
    </datalist>
</div>


        <!--village-->
        <div class="mb-4">
    <x-input-label for="village" value="Village" />

    <x-text-input
        id="village"
        name="village"
        type="text"
        
        placeholder="Type village here"
        class="block w-full"
    />

    
</div>
       <div class="mb-4">
        <label>Pincode</label>
           <input type="text" name="pincode" pattern="[0-9]{6}" placeholder="Enter Pincode" required>
</div>



        <div class="mb-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" name="password" type="password" required />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="mb-4">
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" required />
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full">Register</x-primary-button>
        </div>

        <p class="mt-4 text-center">
            <a href="{{ route('seller.login') }}" class="text-blue-500 hover:underline">Already have an account? Login</a>
        </p>
        <p class="mt-4 text-center">
            <a href="{{ url('/') }}" class="text-black-500 hover:underline">Back to home</a>
        </p>
    </form>
</x-guest-layout>
