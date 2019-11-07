@extends ('layouts.app')

@section ('content')
    <div class="card mb-10">
        <div class="form-container mt-4">
            <div class="form-heading">Create Customer</div>
            <form
                action="/customers"
                method="POST"
            >
                @csrf

                <div class="form-element-group">
                    <label for="first_name" class="form-label">
                        First Name
                    </label>
                    <input
                        name="first_name"
                        type="text"
                        id="first_name"
                        value="{{ old('first_name') }}"
                        class="form-input @error('first_name') error-input @enderror"
                    >
                    @error('first_name')
                    <span role="alert" class="error-text">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-element-group">
                    <label for="last_name" class="form-label">
                        Last Name
                    </label>
                    <input
                        name="last_name"
                        type="text"
                        id="last_name"
                        value="{{ old('last_name') }}"
                        class="form-input @error('last_name') error-input @enderror"
                    >
                    @error('last_name')
                    <span role="alert" class="error-text">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-element-group">
                    <label for="telephone" class="form-label">
                        Telephone
                    </label>
                    <input
                        name="telephone"
                        type="text"
                        id="telephone"
                        value="{{ old('telephone') }}"
                        class="form-input @error('telephone') error-input @enderror"
                    >
                    @error('telephone')
                    <span role="alert" class="error-text">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-element-group">
                    <label for="email" class="form-label">
                        email
                    </label>
                    <input
                        name="email"
                        type="email"
                        id="email"
                        value="{{ old('email') }}"
                        class="form-input @error('email') error-input @enderror"
                    >
                    @error('email')
                    <span role="alert" class="error-text">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-element-group">
                    <label for="address" class="form-label">
                        Address
                    </label>
                    <input
                        name="address"
                        type="text"
                        id="address"
                        value="{{ old('address') }}"
                        class="form-input @error('address') error-input @enderror"
                    >
                    @error('address')
                    <span role="alert" class="error-text">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-element-group">
                    <label for="address2" class="form-label">
                        Address 2
                    </label>
                    <input
                        name="address2"
                        type="text"
                        id="address2"
                        value="{{ old('address2') }}"
                        class="form-input @error('address2') error-input @enderror"
                    >
                    @error('address2')
                    <span role="alert" class="error-text">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-element-group">
                    <label for="city" class="form-label">
                        City
                    </label>
                    <input
                        name="city"
                        type="text"
                        id="city"
                        value="{{ old('city') }}"
                        class="form-input @error('city') error-input @enderror"
                    >
                    @error('city')
                    <span role="alert" class="error-text">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-element-group">
                    <label for="state" class="form-label">
                        State
                    </label>
                    <input
                        name="state"
                        type="text"
                        id="state"
                        value="{{ old('state') }}"
                        class="form-input @error('state') error-input @enderror"
                    >
                    @error('state')
                    <span role="alert" class="error-text">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-element-group">
                    <label for="zip" class="form-label">
                        Zip Code
                    </label>
                    <input
                        name="zip"
                        type="text"
                        id="zip"
                        value="{{ old('zip') }}"
                        class="form-input @error('zip') error-input @enderror"
                    >
                    @error('zip')
                    <span role="alert" class="error-text">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-footer">
                    <button
                        type="submit"
                        class="button"
                    >
                        Create Customer
                    </button>
                    <a href="/customers" class="button">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
