import React from 'react'
import { Inertia } from '@inertiajs/inertia'

const Post = ({ to, data = {}, render }) => {
    const handler = () => {
        Inertia.post(to, data)
    }

    return render({ handler })
}

export default Post
