const express = require('express')
const gatewayRouter = require('./routers/gateway')
const app = express()
const port = 3000;

app.use(express.json())
app.use('/gateway', gatewayRouter);

app.listen(port, () => {
  console.log(`Example app listening on port ${port}`)
})