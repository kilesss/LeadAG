<template>

    <div class="container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div v-for="(error, key) in errors" :key="key">
                        <div class="alert alert-danger col-md-12" v-for="(errorItem, innerKey) in error" :key="innerKey" style="margin-top: 2rem">
                            {{ errorItem }}
                          </div>
                    </div>
                    <div class="card">
                        <div class="card-header">New Credit</div>
                        <div class="card-body">
                            <form @submit="formSubmit">
                                <strong>Name:</strong>
                                <input type="text" class="form-control" v-model="name">
                                <strong>Amount:</strong>
                                <input type="text" class="form-control" v-model="amount">
                                <strong>Months: {{customRange}}</strong>
                                <!--use value=1-->
                                <input type="range" @change="changeSlider"  v-model="customRange" class="form-range " id="customRange" min="3" max="120" value="3" step="1" />
                                <div class="d-flex justify-content-between">
                                    <span>3</span>
                                    <span>120</span>
                                </div>
                                <button class="btn btn-success">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import router from "../router/index.js";

export default {
    mounted() {
    },
    data() {
        return {
            name: '',
            amount: '',
            customRange: '3',
            errors:[]
        };
    },
    methods: {
        formSubmit(e) {
            e.preventDefault();
            let currentObj = this;
            axios.post('api/submitCredit', {
                name: this.name,
                amount: this.amount,
                customRange: this.customRange
            }) .then(response => {
                // this.databaseConfiguration = response.data;
                router.push({ path: '/' })
            }).catch(error =>{
                if (error.response.data.errors.single_error !== undefined){
                    let err = [];
                    err.push({'error':error.response.data.errors.single_error })
                    this.errors =err;
                }else{
                    this.errors = error.response.data.errors
                }
            })
        },
        changeSlider(e) {
            $("[name=values]").val(this.customRange)//assign value..
            this.months = this.customRange;
        }
    }
}
</script>
