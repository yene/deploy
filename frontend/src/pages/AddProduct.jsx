import React from 'react'
import { useNavigate } from 'react-router-dom'
import { useState } from 'react'
import { useProduct } from '../hooks/use-product'

//post request
// async function postJsonData(jsonObject) {
//     const response = await fetch("/echo", {
//         method: "POST",
//         headers: {'Content-Type': 'application/json'},
//         body: JSON.stringify(jsonObject)
//     });

//     const actualResponse = await response.json();
// }

function AddProduct(props) {
  const navigate = useNavigate()
  const product = useProduct()
  //const onSubmitForm = document.getElementById('product_form');
  //console.log("on submit form", onSubmitForm);
  const [sku, setSku] = useState('')
  const [name, setName] = useState('')
  const [price, setPrice] = useState('')
  const [productType, setProductType] = useState('') //how to assign it
  const [size, setSize] = useState('')
  const [weight, setWeight] = useState('')
  const [height, setHeight] = useState('')
  const [length, setLength] = useState('')
  const [width, setWidth] = useState('')

  const handleSubmit = (e) => {
    e.preventDefault()
    product.create.mutate({
      sku,
      name,
      price,
      type: productType,
      size,
      weight,
      height,
      length,
      width,
    })
  }

  let extras = null


  if (productType === 'Book'){
    extras = (
      <div id="option-container">
      <div id="BOOK" className="container">
    <h4>Book</h4>
    <p>* Please Provide Weight in KG</p>

    <div className="row mb-3">
      <div className="col-2">
        <label htmlFor="weight" className="form-label">
          Weight (KG)
        </label>
      </div>
      <div className="col-4">
        <input
          type="number"
          id="weight"
          className="form-control"
          placeholder="Weight"
          name="product_weight"
          value={weight}
          onChange={(e) => setWeight(e.target.value)}
        />
      </div>
    </div>
    </div>
  </div>
    )
  }

  if (productType === 'Furniture'){
    extras = (
      <div id="option-container">
  <div id="Furniture" className="container">
  <div className="row mb-3">
    <div className="col-12">
      <h4 className="mb-2">Furniture info</h4>
      <p>* Please Provide Height, Width and Length in CM</p>

      <div className="row mb-3">
        <div className="col-2">
          <label htmlFor="height" className="form-label">
            Height (CM)
          </label>
        </div>
        <div className="col-4">
          <input
            type="number"
            id="height"
            className="form-control"
            placeholder="Height"
            name="product_height"
            onChange={(e) => setHeight(e.target.value)}
            value={height}
          />
        </div>
      </div>
      <div className="row mb-3">
        <div className="col-2">
          <label
            htmlFor="width"
            className="form-label align-text-bottom"
          >
            Width (CM)
          </label>
        </div>
        <div className="col-4">
          <input
            type="number"
            id="width"
            className="form-control"
            placeholder="Width"
            name="product_width"
            onChange={(e) => setWidth(e.target.value)}
            value={width}
          />
        </div>
      </div>
      <div className="row mb-3">
        <div className="col-2 align-bottom">
          <label htmlFor="length" className="form-label">
            Length (CM)
          </label>
        </div>
        <div className="col-4">
          <input
            type="number"
            id="length"
            className="form-control"
            placeholder="Length"
            name="product_length"
            onChange={(e) => setLength(e.target.value)}
            value={length}
          />
        </div>
      </div>
    </div>
  </div>
</div>
</div>

    )
  }

  if (productType === 'DVD') {
    extras = (
      <div id="option-container">
        <div id="DVD" className="container">
          <h4>DVD info</h4>
          <p>* Please Provide Size</p>
          <div className="row mb-3">
            <div className="col-2">
              <label htmlFor="size" className="form-label">
                Size (MB)
              </label>
            </div>
            <div className="col-4">
              <div>
                <input
                  type="number"
                  id="size"
                  className="form-control"
                  placeholder="Size"
                  name="product_size"
                  value={size}
                  onChange={(e) => setSize(e.target.value)}
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    )
  } 



  return (
    <div>
      {/* <div id="errorBlock" className="alert alert-danger d-none" role="alert">
                <h3 className="alert-heading">Error!</h3>
                <p className="error">The following error(s) occurred:
                    <ul id="errorList"> </ul>
                </p>
            </div> */}
      {product.create.error && (
        //JSON.stringify(product.create.error, null, 2)
        <div id="errorBlock" className="alert alert-danger" role="alert">
          <h3 className="alert-heading">Error!</h3>
          <div className="error">
            The following error(s) occurred:
            <ul id="errorList">
              <li>
                {product.create.error.errorMessage} -{' '}
                {product.create.error.errorCode}
              </li>
            </ul>
          </div>
        </div>
      )}

      <div className="container">
        <form
          className="row mt-5 g-3"
          method="post"
          onSubmit={(e) => {
            handleSubmit(e)

          }}
        >
          <div className="container">
            <div className="row">
              <div className="col-9">
                <div className="header">
                  <h2 className="border-bottom border-secondary border-3">
                    Product Add
                  </h2>
                </div>
              </div>
              <div className="col-3">
                <button
                  type="submit"
                  name="submit"
                  className="btn btn-primary"
                  value="Submit"
                  // onClick={() => {
                  //   navigate('/')
                  // }}
                >
                  Save
                </button>
                {/* <a className="btn btn-danger" href="./index.php">Cancel</a> */}
                <button
                  type="button"
                  className="btn btn-danger"
                  onClick={() => {
                    navigate('/')
                  }}
                >
                  Cancel
                </button>
              </div>
            </div>
          </div>

          <div className="container">
            <div className="row mb-3">
              <div className="col-1">
                <label htmlFor="sku" className="form-label">
                  SKU
                </label>
              </div>
              <div className="col-5">
                <input
                  id="sku"
                  type="text"
                  className="form-control main-input"
                  name="product_SKU"
                  onChange={(e) => setSku(e.target.value)}
                  placeholder="SKU"
                  onInvalid={(e) =>
                    e.target.setCustomValidity('Please Submit Required Data')
                  }
                  onInput={(e) => e.target.setCustomValidity('')}
                  value={sku}
                  required
                />
              </div>
            </div>
          </div>

          <div className="container">
            <div className="row mb-3">
              <div className="col-1">
                <label htmlFor="name" className="form-label">
                  Name
                </label>
              </div>
              <div className="col-5">
                <input
                  id="name"
                  type="text"
                  className="form-control main-input"
                  name="product_name"
                  onChange={(e) => setName(e.target.value)}
                  placeholder="Name"
                  onInvalid={(e) =>
                    e.target.setCustomValidity('Please Submit Required Data')
                  }
                  onInput={(e) => e.target.setCustomValidity('')}
                  value={name}
                  required
                />
              </div>
            </div>
          </div>

          <div className="container">
            <div className="row mb-3">
              <div className="col-1">
                <label htmlFor="price" className="form-label">
                  Price
                </label>
              </div>
              <div className="col-5">
                <input
                  id="price"
                  type="number"
                  step=".01"
                  className="form-control main-input"
                  name="product_price"
                  onChange={(e) => setPrice(e.target.value)}
                  placeholder="Price"
                  onInvalid={(e) =>
                    e.target.setCustomValidity('Please Submit Required Data')
                  }
                  onInput={(e) => e.target.setCustomValidity('')}
                  value={price}
                  required
                />
              </div>
            </div>
          </div>

          <div className="container">
            <div className="row mb-3">
              <div className="col-2">
                <label htmlFor="productType" className="form-label">
                  Type Switcher
                </label>
              </div>
              <div className="col-4">
                <select
                  required
                  defaultValue={'DEFAULT'}
                  id="productType"
                  className="form-select"
                  aria-label="Default select example"
                  name="product_type"
                  onChange={(e) => {
                    setProductType(e.target.value)
                  }}
                >
                  <option value="DEFAULT" disabled>
                    Select the Product Type
                  </option>
                  <option value="DVD">DVD</option>
                  <option value="Furniture">Furniture</option>
                  <option value="Book">Book</option>
                </select>
              </div>
            </div>
          </div>

          <div id="option-container">
          {extras}
          </div>
        </form>
      </div>
    </div>
  )
}

export default AddProduct