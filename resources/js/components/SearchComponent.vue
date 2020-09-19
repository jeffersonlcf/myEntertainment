<template>
    <article class="dropdown mx-2 d-inline w-100">
        <section class="">
            <input class="form-control" type="text" placeholder="Search" v-model="search" v-on:keyup="findFilms">
            
            <div class="dropdown-menu w-100" :class="{show: loading}">
                <p class="text-center pt-3">
                    <font-awesome-icon icon="spinner" pulse size="3x" />
                </p>
            </div>
             <div class="dropdown-menu w-100" :class="{show: isActive}">
                <table class="table table-hover table-borderless">
                    <tbody>
                        <tr v-if="this.results.length === 0">
                            <th scope="row">
                                <p class="text-center">Oops... Nothing Found!</p>   
                            </th>
                        </tr>
                        <tr v-else v-bind:key="result.id" v-for="result in results">
                            <th scope="row">
                                <div class="d-inline-flex">
                                    <div class="float-left mr-2">
                                        <svg v-if="result.image === ''" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 25 25" fill="currentColor" role="presentation"><path d="M18 4v1h-2V4c0-.55-.45-1-1-1H9c-.55 0-1 .45-1 1v1H6V4c0-.55-.45-1-1-1s-1 .45-1 1v16c0 .55.45 1 1 1s1-.45 1-1v-1h2v1c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-1h2v1c0 .55.45 1 1 1s1-.45 1-1V4c0-.55-.45-1-1-1s-1 .45-1 1zM8 17H6v-2h2v2zm0-4H6v-2h2v2zm0-4H6V7h2v2zm10 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V7h2v2z"></path></svg>
                                        <img v-else v-bind:alt="result.title" v-bind:src="result.image" class="rounded" width="50">
                                    </div>
                                    <div>
                                        <a :href="result.showUrl">
                                            <h5>
                                                {{ result.title }} ({{ result.typeName }})
                                            </h5>
                                            <p>{{ result.year }}</p>
                                        </a>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </article>
</template>

<script>

    // Font Awesome 5
    import { library } from '@fortawesome/fontawesome-svg-core'
    import { faSpinner  } from '@fortawesome/free-solid-svg-icons'
    library.add( faSpinner );

    export default {
        data: function() {
            return {
                loading: false,
                search: '',
                isActive: false,
                results: [],
                timer: 0,
            };
        },
        created: function () {
            this.clickOutside();
        },
        methods: {
            findFilms: function () {

                this.loading = true;
                clearTimeout(this.timer);
                this.timer = 0;

                this.timer = setTimeout(() => {
                    if (this.query === '') {
                        this.loading = this.isActive = false;
                    } else {
                        axios.get(this.url).then(response => {
                            this.loading = false;
                            this.results = response.data.results;
                            this.isActive = true;
                        });
                    }
                }, 500);
            },
            clickOutside: function () {
                let self = this;
                window.addEventListener('click', function (e) {
                    if (!self.$el.contains(e.target)) {
                        self.isActive = false;
                    }
                });
            }
        },
        computed: {
            url(){
                return '/api/search/remote?q=' + this.query;
            },
            query(){
                return this.search.trim();
            }
        } 
    }
</script>