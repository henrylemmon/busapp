@extends ('layouts.app')

@section ('content')
    <div class="card mb-10">
        <div class="form-container">
            <div class="form-heading">Edit Address</div>
            <form
                action="{{ $address->path() }}"
                method="POST"
            >
                @csrf
                @method('PATCH')

                <div class="form-element-group">
                    <label for="address" class="form-label">
                        Address
                    </label>
                    <input
                        name="address"
                        type="text"
                        id="address"
                        class="form-input @error('address') error-input @enderror"
                        value="{{ old('address') ? old('address') : $address->address }}"
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
                        class="form-input @error('address2') error-input @enderror"
                        value="{{ old('address2') ? old('address2') : $address->address2 }}"
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
                        class="form-input @error('city') error-input @enderror"
                        value="{{ old('city') ? old('city') : $address->city }}"
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
                        class="form-input @error('state') error-input @enderror"
                        value="{{ old('state') ? old('state') : $address->state }}"
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
                        class="form-input @error('zip') error-input @enderror"
                        value="{{ old('zip') ? old('zip') : $address->zip }}"
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
                        Edit Address
                    </button>
                    <a class="button" href="{{ $address->customer->path() }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
