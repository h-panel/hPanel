import React from 'react';
import { ServerContext } from '@/state/server';
import PageContentBlock, { PageContentBlockProps } from '@/components/elements/PageContentBlock';

interface Props extends PageContentBlockProps {
    title: string;
}

const ServerContentBlock: React.FC<Props> = ({ title, children, ...props }) => {
    const name = ServerContext.useStoreState((state) => state.server.data!.name);

    return (
        <PageContentBlock title={`${name} | ${title}`} {...props}>
            {children}
        </PageContentBlock>
    );
};

export default ServerContentBlock;
