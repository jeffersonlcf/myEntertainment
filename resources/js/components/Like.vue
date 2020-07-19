<template>
    <b-button-group>
        <b-button variant="border-0" @click="toggleLike(1)" :class="{ 'btn-success': like === 1 }"><span class="icon">✔</span></b-button>
        <b-button variant="border-0" @click="toggleLike(0)" :class="{ 'btn-danger': like === 0 }"><span class="icon">✖</span></b-button>
    </b-button-group>
</template>


<script>

export default {
    name: 'Like',
    props: {
        url: String,
        initialLike: Number,
    },
    data: function() {
        return {
            like: this.initialLike,
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