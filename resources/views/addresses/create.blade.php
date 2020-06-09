@extends ('layouts.app')

@section ('content')
    <div class="card mb-10">
        <div class="form-container">
            <div class="form-heading">Create Address</div>
            <form
                action="{{ $customer->path() . '/addresses' }}"
                method="POST"
            >
                @csrf

                <div class="form-element-group">
                    <label for="address" class="form-label">
                        Address
                    </label>
                    <input
                        name="address"
                        type="text"
                        id="address"
                        value="{{ old('address') }}"
                        required
                        maxlength="35"
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
                        maxlength="20"
                        class="form-input @error('address2') error-input @enderror"
                    >
                    @error('address2')
                    <span role="alert" class="error-text">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-element-group">
                    <label for="city" class="form-lable">
                        City
                    </label>
                    <input
                        name="city"
                        type="text"
                        id="city"
                        value="{{ old('city') }}"
                        required
                        maxlength="25"
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
                        required
                        maxlength="2"
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
                        maxlength="20"
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
                        Create Address
                    </button>
                    <a class="button" href="{{ $customer->path() }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
