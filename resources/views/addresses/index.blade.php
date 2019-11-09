@extends ('layouts.app')

@section ('content')
    @forelse($addresses as $address)
        <div class="flex items-end mt-4">
            <div class="mr-6">
                {{ $address->address }}<br>
                @isset($address->address2)
                    {{ $address->address2 }}<br>
                @endisset
                {{ $address->city . ' ' . $address->state }}<br>
                {{ $address->zip }}<br>
            </div>
            <div>
                <a
                    href="{{ $address->path() . '/edit' }}"
                    class="button text-center mr-4"
                >Edit {{ $address->billing_address ? 'Billing' : 'Job' }} Address</a>

                <form
                    action="{{ $address->path() }}"
                    method="POST"
                    class="inline-block mr-4 leading-tight"
                >
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="button text-center"
                    >
                        Delete {{ $address->billing_address ? 'Billing' : 'Job' }} Address
                    </button>
                </form>

                <a
                    href="{{ $address->customer->path() }}"
                    class="button text-center"
                >Cancel</a>
            </div>
        </div>
        <hr class="border-gray-500 mt-4">
    @empty
        Need To Add An Address!
    @endforelse
@endsection
