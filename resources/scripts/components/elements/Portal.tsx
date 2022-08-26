import React, { useRef } from 'react';
import { createPortal } from 'react-dom';

export default ({ children }: { children: React.ReactNode }) => {
    const element = useRef(document.getElementById('modal-portal'));

    return createPortal(children, element!.current!);
};
