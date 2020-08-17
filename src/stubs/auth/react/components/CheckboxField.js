import React from 'react'
import useId from '@/helpers/use-id'

const CheckboxField = ({ label, value = false, onChange }) => {
    const id = useId()

    return (
        <div>
            <input
                type="checkbox"
                id={id}
                checked={value}
                onChange={event => onChange(event.target.checked)}
            />
            {label && <label htmlFor={id}>{label}</label>}
        </div>
    )
}

export default CheckboxField
