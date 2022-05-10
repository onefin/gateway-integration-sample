const express = require('express');
const { generatePayment, checkPaymentStatus, callback } = require('../services/payment-gateway');
const gatewayRouter = express.Router();

gatewayRouter.post('/generatePayment', generatePayment);

gatewayRouter.post('/checkTransaction', checkPaymentStatus);

gatewayRouter.post('/callback', callback);


//export this router to use in our index.js
module.exports = gatewayRouter;