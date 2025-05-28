<x-dashboard.layout.default title="Edit Member">
    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('teams.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.users-group class="h-3 w-3 me-2" />
                Team Members
            </a>
        </li>
        <x-dashboard.ui.bread-crumb-list name="Edit" />
    </x-dashboard.ui.bread-crumb>

    <x-ui.card heading="Edit Team Member">
        <form action="{{ route('teams.update', $teamMember->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="space-y-2 mx-5">
                <div class="grid grid-cols-3">
                    <div class="px-2">
                        <x-ui.form.input id="member-name" name="name" label="Member Name" placeholder="Enter Name"
                            class="w-full p-2 text-lg" value="{{ $teamMember->name }}" required />
                    </div>
                    <div class="px-2">
                        <x-ui.form.simple-select id="member-type" name="member_type" label="Member Type" required>
                            <option value="1" {{ $teamMember->member_type == 1 ? 'selected' : '' }}>Executive
                            </option>
                            <option value="2" {{ $teamMember->member_type == 2 ? 'selected' : '' }}>Research
                            </option>
                        </x-ui.form.simple-select>
                    </div>


                    <div class="px-2">
                        <x-ui.form.input id="designation" name="designation" label="Designation"
                            class="w-full p-2 text-lg" value="{{ $teamMember->designation }}" required />
                    </div>

                    <div class="p-2 col-span-3">
                        <div class="grid grid-cols-2">

                            <div x-data="clonableInputs" id="clonableInputs" class="w-full max-w-3xl space-y-4"
                                data-social="{{ json_encode($teamMember['social']) }}">
                                <div class="flex items-center mb-4">
                                    <h1 class="text-xl font-bold dark:text-white">Social Inputs</h1>
                                    <button type="button"
                                        class="px-2 py-1 mx-2 dark:text-white rounded hover:bg-gray-600"
                                        @click="addRow">
                                        <x-ui.svg.circle-plus class="w-6 h-6 " />
                                    </button>
                                </div>

                                <!-- Input Rows -->
                                <template x-for="(row, index) in rows" :key="index">
                                    <div class="grid grid-cols-9 items-center">
                                        <!-- Dropdown Select -->
                                        <div class="px-2 col-span-3">

                                            <x-ui.form.simple-select x-model="row.site"
                                                x-bind:name="'social[' + index + '][site]'"
                                                x-bind:required="validate(row)"
                                                class="px-4 py-2 border rounded bg-gray-50 dark:bg-gray-800 dark:text-gray-100">
                                                <option value="" selected>Select a Social Media</option>
                                                <option value="facebook">Facebook</option>
                                                <option value="x">X (Twitter)</option>
                                                <option value="linkedIn">Linked In</option>
                                                <option value="instagram">Instagram</option>
                                                <option value="gitHub">Git Hub</option>
                                                <option value="pinterest">Pinterest</option>
                                                <option value="snapchat">Snapchat</option>
                                                <option value="reddit">Reddit</option>
                                                <option value="tickTok">TickTok</option>
                                                <option value="youTube">YouTube</option>
                                                <option value="discord">Discord</option>
                                                <option value="others">Others</option>
                                            </x-ui.form.simple-select>
                                        </div>

                                        <!-- Input Field -->
                                        <div class="px-2 col-span-5">
                                            <x-ui.form.input x-bind:name="'social[' + index + '][url]'"
                                                x-bind:required="validate(row)" x-model="row.url" type="text"
                                                placeholder="Social URL"
                                                class="px-4 py-2 border rounded bg-gray-50 dark:bg-gray-800 dark:text-gray-100" />
                                        </div>

                                        <!-- Remove Button -->
                                        <div class="px-1">
                                            <button
                                                class="col-span-2 flex items-center justify-center p-2 bg-red-500 text-white rounded hover:bg-red-600"
                                                @click="rows.splice(index, 1)" x-show="rows.length > 1">
                                                <x-ui.svg.close class="h-6 w-6" />
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class=" col-span-1">
                                <div>
                                    <h1 class="text-xl font-bold dark:text-white">Change Member Image</h1>
                                </div>
                                <x-ui.form.image-upload id="dropzone" name="image" oldData="{{$teamMember->image ? asset($teamMember->image) : ''}}" />

                            </div>
                        </div>

                    </div>

                    <div class="col-span-3 my-2 px-2">
                        <label for="text-area" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Description
                        </label>
                        <textarea id="text-area" rows="4" name="description"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Write Member Description here...">{{ $teamMember->description }}</textarea>
                    </div>




                </div>
                <div class="grid grid-cols-7 gap-2">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 m-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 save-button">Save</button>
                    <button form="delete-form" type="button"
                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 m-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 delete-button">Delete</button>

                </div>
            </div>
        </form>

        <form method="POST" action="{{ route('teams.destroy', $teamMember->id) }}" id="delete-form" class="hidden">
            @csrf
            @method('DELETE')
        </form>

    </x-ui.card>

</x-dashboard.layout.default>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('clonableInputs', () => ({
            rows: [{
                site: '',
                url: ''
            }],

            init() {
                const socialElement = document.getElementById('clonableInputs');
                const dataSocial = socialElement.getAttribute('data-social');

                const socialData = JSON.parse(dataSocial);


                if (socialData.length > 0) {
                    this.rows = [...socialData];
                }

            },

            addRow() {
                this.rows.push({
                    site: '',
                    url: ''
                });
            },
            validate(row) {
                // Ensure both fields are required only if one of them is filled
                return row.site !== '' || row.url !== '';
            }
        }));
    });
</script>
