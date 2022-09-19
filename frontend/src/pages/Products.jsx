// import React, { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { useProduct } from '../hooks/use-product'

//mass delete
const baseURL = 'http://localhost:8889'

const Products = () => {
  const navigate = useNavigate()
  const product = useProduct()

  if (product.list.isLoading) {
    return <div>Is loading</div>
  }

  if(product.list.error) {
    return <div>Error Found, please refresh the page</div>
  }

  const executeMassDelete = async () => {
    const allTheCheckboxes = Array.from(
      document.querySelectorAll("input[type='checkbox']")
    )
    const allCheckedCheckboxes = allTheCheckboxes.filter(
      (item) => item.checked === true
    )
    console.log('allCheckedCheckboxes: ', allCheckedCheckboxes)
    const allIdsToDelete = allCheckedCheckboxes.map((item) =>
      Number.parseInt(item.id.replace('item-', ''))
    )
    const promises = []
    for (let id of allIdsToDelete) {
      promises.push(
        fetch(baseURL + '/products/delete/' + id, { method: 'DELETE' })
      )
    }
    await Promise.all(promises)
  }

  return (
    <div>
      <div className="container main">
        <div className="container head">
          <div className="row  mt-5">
            <div className="col-9">
              <div className="header">
                <h1 className="border-bottom border-secondary border-3">
                  Product List
                </h1>
              </div>
            </div>
            <div className="col-3">
              <button
                type="button"
                className="btn btn-primary"
                onClick={() => {
                  navigate('/addproduct')
                }}
              >
                ADD
              </button>
              {/* <Link to="/AddProduct"></Link> */}
              {/* <Link to="/addproduct"> GO TO THE ABOUT PAGE </Link> */}

              {/* add link to other page */}
              <input
                type="button"
                id="delete-product-btn"
                // onclick="document.getElementById('products_form').submit();"
                form="products_form"
                value="MASS DELETE"
                className="btn btn-danger"
                onClick={executeMassDelete}
              />
              {/* fix form */}
            </div>
          </div>
        </div>
        <form id="products_form" action="#" method="POST">
          {/* add action */}
          <div className="container">
            <div className="row mt-3">
              {product.list.data.data.map((product) => (
                <div className="col-3 mb-5" key={product.id}>
                  <div className="card h-100">
                    <div className="card-body">
                      <input
                        type="checkbox"
                        className="delete-checkbox"
                        name={product.name}
                        id={'item-' + product.id}
                      />
                      {/* add value */}
                      <div className="container text-center">
                        <div>
                          <h4 className="card-title">{product.name}</h4>
                          <p className="card-text">{product.price} $</p>
                        </div>
                        {/*
                                        <?php foreach( json_decode($product->attributes) as $key => $attribute ){
                                            echo "<p class='card-text'>{$key}: {$attribute}</p>";
                                        } ?>
                             */}
                      </div>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </form>
      </div>
    </div>
  )
}

export default Products

//option 1
// function pullJson() {
//     fetch(apiUrl)
//         .then(response => response.json())
//         .then(responseData => {
//             productData = responseData.data.map(function (product) {
//                 return (

//                     <div className="col-3 mb-5">
//                         <div className="card h-100">
//                             <div className="card-body">
//                                 <input type="checkbox" className="delete-checkbox" name="products_arr[]" value="" />
//                                 {/* add value */}
//                                 <div className="container text-center">
//                                     <div key={product.id}   >
//                                         <h4 className="card-title">{product.name}</h4>
//                                         <p className="card-text">{product.price} $</p>
//                                     </div>
//                                     {/*
//                                 <?php foreach( json_decode($product->attributes) as $key => $attribute ){
//                                     echo "<p class='card-text'>{$key}: {$attribute}</p>";
//                                 } ?>
//                      */}
//                                 </div>
//                             </div>
//                         </div>
//                     </div>

//                 )
//             })
//             setShowProducts(productData);
//         })
// }
