<template>
    <div class="container">
        <div class="navbar">
            <span>Bringo statistics</span>
        </div>
        <div class="content">
            <div class="panel">
                <div class="panel-title">Dashboard</div>
            </div>
            <div class="card-row">
                <div class="card-item" v-for="card in orders">
                    <div class="card-inner">
                        <div class="card-title">{{card.title}}</div>
                        <div class="card-value" v-if="card.type ==='value'">{{card.value}}</div>
                        <div class="card-chart" v-else>
                            <la-cartesian :width="275" :height="40" :data="card.value">
                                <la-area :color="card.color" animated prop="value"></la-area>
                            </la-cartesian>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { Cartesian, Area } from 'laue'
    import axios from 'axios'
    export default {
        components: {
            LaCartesian: Cartesian,
            LaArea: Area
        },
        mounted() {
            axios.get('/api/orders')
                .then((res) => {
                    this.$set(this.$data, 'orders', res.data.orders)
                })
        },
        data() {
            return {
                orders: [],
                values: [
                    {value: 0},
                    {value: 1},
                    {value: 10},
                    {value: 1000},
                    {value: 10000},
                    {value: 100000}
                ]
            }
        }
    }
</script>
