import React from 'react'
import useId from '@/helpers/use-id'

const TextField = ({
    type = 'text',
    label,
    value,
    errors = [],
    onChange,
    autoFocus = false,
    ...props
}) => {
    const id = useId()

    return (
        <div>
            {label && <label htmlFor={id}>{label}</label>}
            <input
                type={type}
                id={id}
                autoFocus={autoFocus}
                value={value}
                onChange={event => onChange(event.target.value)}
                {...props}
            />
            {errors.map((error, index) => (
                <span key={index}>{error}</span>
            ))}
        </div>
    )
}

export default TextField
