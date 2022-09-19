import { useQuery, useMutation } from '@tanstack/react-query'
//repository pattern
// const baseURL = 'http://localhost:8889'
const baseURL = ''

export const useProduct = () => {
  const list = useQuery(['product.list'], () => {
    return fetch(baseURL + '/products')
      .then(async (response) => {
        const data = await response.json()

        return data
      })
      .then((data) => {
        return data
      }
      
      )
    })
  const create = useMutation((params) => {
    return fetch(baseURL + '/products', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(params),
    })
      .then(async (response) => {
        const data = await response.json()

        if (response.status > 299 || response.status < 200) {
          throw data.data // Error(JSON.stringify(data.data))
        }
        return data
      })
      .then((data) => data.data)
      
    }
  )

  return {
    list,
    create,
  }
}
