<template>

    <div class="content">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                </div>
            </div>
            <div v-for="(error, key) in errors" :key="key">
                <div class="alert alert-danger col-md-12" v-for="(errorItem, innerKey) in error" :key="innerKey"
                     style="margin-top: 2rem">
                    {{ errorItem }}
                </div>
            </div>
            <div class="">
                <button type="btn btn-info" v-on:click='makePayment()'>Payment</button>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Fee</th>
                        <th>Period</th>
                        <th>Created_at</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="data in apiData">
                        <td>{{ data.creditId }}</td>
                        <td>{{ data.name }}</td>
                        <td>{{ data.amount }}</td>
                        <td>{{ data.fee }}</td>
                        <td>{{ data.period }}</td>
                        <td>{{ data.created_at }}</td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="makePayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form @submit="formSubmit">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Make Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <strong>Amount:</strong>
                        <input type="text" class="form-control" v-model="amount">
                        <strong>Credit:</strong>
                        <select class="form-control" v-model="currentPaymentId">
                            <option
                                v-for="data in apiData"
                                :value="data.id"
                            >
                                {{ data.name }}
                            </option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class=" btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="float-end btn btn-success">Submit</button>

                    </div>
                </div>
            </form>

        </div>
    </div>


    <div class="modal fade" id="overpay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Overpay</h5>
                    <button type="button" class="close" @click="refreshPage" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>{{ overpay }}</strong>

                </div>
                <div class="modal-footer">
                    <button type="button" class=" btn btn-secondary" @click="refreshPage" data-dismiss="modal">Close
                    </button>
                    <button class="float-end btn btn-success" @click="refreshPage">Ok</button>

                </div>
            </div>

        </div>
    </div>
</template>
<script>

import router from "../router/index.js";

export default {

    data() {
        return {
            apiData: [],
            currentPaymentId: '',
            amount: '',
            errors: [],
            overpay: ''
        };
    },
    methods: {
        refreshPage() {
            location.reload();
        },
        makePayment(id) {
            this.currentPaymentId = id;
            //maybe its not perfect solution but i can`t find better
            $('#makePayment').modal('show');

        },

        formSubmit(e) {
            e.preventDefault();
            let currentObj = this;
            axios.post('api/makePayment', {
                credit: this.currentPaymentId,
                amount: this.amount,
            }).then(response => {
                // this.databaseConfiguration = response.data;
                location.reload();

            }).catch(error => {
                //maybe its not perfect solution but i can`t find better
                $('#makePayment').modal('hide');

                if (error.response.data.overpay !== undefined) {
                    this.overpay = error.response.data.overpay;
                    $('#overpay').modal('show');

                } else {
                    this.errors = error.response.data.errors
                }
            })
        },

    },
    mounted() {
        const apiUrl = 'api/getCredits';

        axios.get(apiUrl)
            .then((response) => {
                this.apiData = response.data;
            })
            .catch((error) => {
                console.error('Error fetching data:', error);
            });
    },
};
</script>
