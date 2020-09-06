<template>
    <div class="rating">
        <ul class="list">
            <li @click="rate(star)" v-for="star in maxStars" :class="{ 'active': star <= stars }" :key="star.stars" class="star">
                <font-awesome-icon :icon="['fas', 'star']"/> 
            </li>
        </ul>
    </div>
</template>


<script>

// Font Awesome 5
import { library } from '@fortawesome/fontawesome-svg-core'
import { faStar  } from '@fortawesome/free-solid-svg-icons'
library.add( faStar );


export default {
    name: 'StarRating',
    props: {
        url: String,
        initialStars: Number,
    },
    data: function() {
        return {
            stars: this.initialStars,
            maxStars: 5,
        }
    },

    methods: {
        rate: function(star) {
            if (star === this.stars){
                this.stars = 0;
            } else {
                this.stars = star;
            }
            axios.put(this.url, {stars: this.stars})
            .then(response => {
                this.stars = response.data.stars;
            })
            .catch(error => console.log(error));
        }
    }
}
</script>


<style scoped>
.rating .list{
    color: grey;
    display: inline-block;
}

.rating .list .star {
    display: inline-block;
    font-size: 23px;
    transition: all .2s ease-in-out; 
    cursor: pointer;
}

@media (min-width: 992px) { 
    .rating .list:hover .star {
        color: #ffe100;
    }
}

.rating .list .star:hover ~ .star:not(.active){
    color: inherit;
}

.active {
    color: #ffe100; 
}
</style>