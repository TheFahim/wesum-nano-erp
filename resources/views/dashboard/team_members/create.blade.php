<x-dashboard.layout.default title="Add a New Member">
    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('teams.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.users-group class="h-3 w-3 me-2" />
                Team Members
            </a>
        </li>
        <x-dashboard.ui.bread-crumb-list name="Create" />
    </x-dashboard.ui.bread-crumb>

    <x-ui.card heading="Add New Team Member">
        <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-2 mx-5">
                <div class="grid grid-cols-3">
                    <div class="px-2">
                        <x-ui.form.input id="member-name" name="name" label="Member Name" placeholder="Enter Name"
                            class="w-full p-2 text-lg" required />
                    </div>
                    <div class="px-2">
                        <x-ui.form.simple-select id="member-type" name="member_type" label="Member Type" required>
                            <option value="2">Research</option>
                            <option value="1">Executive</option>
                        </x-ui.form.simple-select>
                    </div>


                    <div class="px-2">
                        <x-ui.form.input id="designation" name="designation" label="Designation"
                            class="w-full p-2 text-lg" required />
                    </div>

                    <div class="p-2 col-span-3">
                        <div class="grid grid-cols-2">

                            <div class="w-full max-w-3xl space-y-4" x-data="clonableInputs">
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
                                                <option value="facebook" x-bind:selected="row.site === 'facebook'">
                                                    Facebook</option>
                                                <option value="x" x-bind:selected="row.site === 'x'">X
                                                    (Twitter)</option>
                                                <option value="linkedIn" x-bind:selected="row.site === 'linkedIn'">
                                                    Linked In</option>
                                                <option value="instagram" x-bind:selected="row.site === 'instagram'">
                                                    Instagram</option>
                                                <option value="gitHub" x-bind:selected="row.site === 'gitHub'">Git Hub
                                                </option>
                                                <option value="pinterest" x-bind:selected="row.site === 'pinterest'">
                                                    Pinterest</option>
                                                <option value="snapchat" x-bind:selected="row.site === 'snapchat'">
                                                    Snapchat</option>
                                                <option value="reddit" x-bind:selected="row.site === 'reddit'">Reddit
                                                </option>
                                                <option value="tickTok" x-bind:selected="row.site === 'tickTok'">
                                                    TickTok</option>
                                                <option value="youTube" x-bind:selected="row.site === 'youTube'">
                                                    YouTube</option>
                                                <option value="discord" x-bind:selected="row.site === 'discord'">
                                                    Discord</option>

                                                <option value="others" x-bind:selected="row.site === 'others'">Others
                                                </option>
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
                                            <button type="button"
                                                class="col-span-2 flex items-center justify-center p-2 bg-red-500 text-white rounded hover:bg-red-600"
                                                @click="rows.splice(index, 1)" x-show="rows.length > 1">
                                                <x-ui.svg.close class="h-6 w-6" />
                                            </button>
                                        </div>
                                    </div>
                                </template>


                            </div>

                            <div class="col-span-1">
                                <div>
                                    <h1 class="text-xl font-bold dark:text-white">Upload Member Image</h1>
                                </div>
                                <x-ui.form.image-upload id="dropzone" name="image" />

                            </div>


                        </div>

                    </div>

                    <div class="col-span-3 my-2 px-2">
                        <label for="text-area" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Description
                        </label>
                        <textarea id="text-area" rows="4" name="description"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Write Member Description here...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>




                </div>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 save-button">Save</button>
            </div>
        </form>

    </x-ui.card>

</x-dashboard.layout.default>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('clonableInputs', () => ({
            rows: {!! json_encode(old('social', [['site' => '', 'url' => '']])) !!},
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
