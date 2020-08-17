import React from 'react'

const Button = ({ children, ...rest }) => <button {...rest}>{children}</button>

export default Button
