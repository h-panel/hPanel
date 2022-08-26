import tw from 'twin.macro';
import { Form } from 'formik';
import { breakpoint } from '@/theme';
import React, { forwardRef } from 'react';
import styled from 'styled-components/macro';
import FlashMessageRender from '@/components/FlashMessageRender';

type Props = React.DetailedHTMLProps<React.FormHTMLAttributes<HTMLFormElement>, HTMLFormElement> & {
    title?: string;
};

const Container = styled.div`
    ${breakpoint('sm')`
        ${tw`w-4/5 mx-auto`}
    `};

    ${breakpoint('md')`
        ${tw`p-10`}
    `};

    ${breakpoint('lg')`
        ${tw`w-3/5`}
    `};

    ${breakpoint('xl')`
        ${tw`w-full`}
        max-width: 700px;
    `};
`;

export default forwardRef<HTMLFormElement, Props>(({ title, ...props }, ref) => (
    <Container>
        {title && <h2 css={tw`text-3xl text-center text-neutral-100 font-medium py-4`}>{title}</h2>}
        <FlashMessageRender css={tw`mb-2 px-1`} />
        <Form {...props} ref={ref}>
            <div css={tw`md:flex w-full bg-neutral-900 shadow-lg rounded-lg p-6 md:pl-0 mx-1`}>
                <div css={tw`flex-none select-none mb-6 md:mb-0 self-center`}>
                    <img src={'https://cdn.discordapp.com/attachments/987734229469253674/1012377713065078845/orb_1024_1024px_180_180px_1024_1024px.png'} css={tw`block w-48 md:w-64 mx-auto`} />
                </div>
                <div css={tw`flex-1`}>{props.children}</div>
            </div>
        </Form>
    </Container>
));
