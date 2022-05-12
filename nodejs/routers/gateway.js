const express = require('express');
const { generatePayment, checkPaymentStatus, callback, queryToken, unbindCard } = require('../services/payment-gateway');
const gatewayRouter = express.Router();

gatewayRouter.post('/generatePayment', generatePayment);

gatewayRouter.post('/checkTransaction', checkPaymentStatus);

gatewayRouter.post('/queryToken', queryToken);

gatewayRouter.post('/unbindCard', unbindCard);

gatewayRouter.post('/callback', callback);


//export this router to use in our index.js
module.exports = gatewayRouter;