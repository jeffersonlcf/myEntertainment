<template>
    <b-button-group>
        <b-button variant="border-0" @click="toggleLike(true)" :class="{ 'btn-success': like === true }"><span class="icon">✔</span></b-button>
        <b-button variant="border-0" @click="toggleLike(false)" :class="{ 'btn-danger': like === false }"><span class="icon">✖</span></b-button>
    </b-button-group>
</template>


<script>

export default {
    name: 'Like',
    props: {
        url: String,
        loadLike: {
            type: Boolean,
            default: null,
        },
    },
    data: function() {
        return {
            like: this.loadLike,
        }
    },

    methods: {
        toggleLike: function (value) {
            if (this.like === value){
                this.like = null;
            } else {
                this.like = value;
            }
            axios.put(this.url, {like: this.like})
            .then(response => {
                this.like = response.data.like;
            })
            .catch(error => console.log(error));
        },
    }
}
</script>

<style scoped>
.icon {
    font-size: 25px;
}
</style>