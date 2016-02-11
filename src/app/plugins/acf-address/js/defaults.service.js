'use strict'

let post_id = 1

module.exports = ($) => {

  return $.ajax({
    url : window.ajaxurl,
    type : 'post',
    data : {
      action : 'get_acf_address_data',
      post_id : post_id
    }
  })
    .then(res => {
      alert(res)
      return res
    })

}
