<div x-data="modalDelete()" x-on:open-modal-delete.window="toggleModal()" x-on:close-modal-delete.window="toggleModal()">
    <!-- Backdrop -->
    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 z-50"></div>
    <!-- Modal -->
    <div x-show="open" @click.away="toggleModal()" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-base-800">
                <button @click="toggleModal()" type="button" class="absolute top-3 end-2.5  bg-transparent hover:bg-base-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-base-600 dark:hover:">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4  w-12 h-12 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal  ">Are you sure you want to delete this product?</h3>
                    <button @click="submit()" type="button" class=" bg-red-600 hover:bg-red-800 focus:ring-4 text-base-50 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes, I'm sure
                    </button>
                    <button @click="toggleModal()" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-base-200 hover:bg-base-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-base-800  dark:border-base-600 dark:hover: dark:hover:bg-base-800">No, cancel</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('modalDelete', () => ({
            open: false,
            id : null,
            route: null,
            toggleModal() {
                this.open = !this.open;
                this.id = this.$event.detail.id
                this.route = this.$event.detail.route
            },
            submit() {
                if (this.id) {
                    this.$wire[this.route](this.id)
                }
                else
                this.$wire[this.route]()
            }
        }))
        Alpine.bind('modalDeleteButton', () => ({
            '@click'() {
                this.$dispatch('open-modal-delete',this.$event.currentTarget.dataset)
            },
        }))
    })
</script>