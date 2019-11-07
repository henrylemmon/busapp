@extends ('layouts.app')

@section ('content')
    <div class="card mb-10">
        <div class="form-container mt-4">
            <div class="form-heading">Edit Customer</div>
            <form
                action="{{ $customer->path() }}"
                method="POST"
            >
                @method('PATCH')
                @csrf

                <div class="form-element-group">
                    <label for="first_name" class="form-label">
                        First Name
                    </label>
                    <input
                        name="first_name"
                        type="text"
                        id="first_name"
                        value="{{ old('first_name') ? old('first_name') : $customer->first_name }}"
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
                        value="{{ old('last_name') ? old('last_name') : $customer->last_name }}"
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
                        value="{{ old('telephone') ? old('telephone') : $customer->telephone }}"
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
                        Email
                    </label>
                    <input
                        name="email"
                        type="email"
                        id="email"
                        value="{{ old('email') ? old('email') : $customer->email }}"
                        class="form-input @error('email') error-input @enderror"
                    >
                    @error('email')
                    <span role="alert" class="error-text">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="inline-block w-full mb-8">
                    <label for="new_billing_address" class="form-label">
                        Select Billing Address
                    </label>
                    <div class="relative">
                        <select
                            name="new_billing_address_id"
                            id="new_billing_address"
                            class="block appearance-none w-full bg-white border border-gray-400 px-2 py-1 pr-8 rounded shadow"
                        >
                            @isset($customer->billingAddress()->id)
                                <option
                                    value="{{ $customer->billingAddress()->id }}"
                                >
                                    {{ $customer->billingAddress()->address }}
                                    {{ $customer->billingAddress()->address2 }}
                                    {{ $customer->billingAddress()->city }}
                                    {{ $customer->billingAddress()->state }}
                                    {{ $customer->billingAddress()->zip }}
                                </option>
                            @endisset
                            @foreach($customer->addresses->where('billing_address', false) as $address)
                                <option value="{{ $address->id }}">
                                    {{ $address->address }}
                                    {{ $address->address2 }}
                                    {{ $address->city }}
                                    {{ $address->state }}
                                    {{ $address->zip }}
                                </option>
                            @endforeach
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                        >
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <button
                        type="submit"
                        class="button"
                    >
                        Edit Customer
                    </button>
                    <a href="{{$customer->path()}}" class="button">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
