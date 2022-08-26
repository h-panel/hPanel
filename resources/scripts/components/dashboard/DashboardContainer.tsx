import useSWR from 'swr';
import tw from 'twin.macro';
import * as Icon from 'react-feather';
import getServers from '@/api/getServers';
import useFlash from '@/plugins/useFlash';
import { useStoreState } from 'easy-peasy';
import { PaginatedResult } from '@/api/http';
import { useLocation } from 'react-router-dom';
import { Server } from '@/api/server/getServer';
import Switch from '@/components/elements/Switch';
import React, { useEffect, useState } from 'react';
import Spinner from '@/components/elements/Spinner';
import ServerRow from '@/components/dashboard/ServerRow';
import Pagination from '@/components/elements/Pagination';
import { usePersistedState } from '@/plugins/usePersistedState';
import PageContentBlock from '@/components/elements/PageContentBlock';
import ScreenBlock from '@/components/elements/ScreenBlock';
import NotFoundSvg from '@/assets/images/not_found.svg';
import { megabytesToHuman } from '@/helpers';
import StoreContainer from '@/components/elements/StoreContainer';
import { getResources, Resources } from '@/api/store/getResources';
import TitledGreyBox from '@/components/elements/TitledGreyBox';
import styled from 'styled-components/macro';
import { Link } from 'react-router-dom';
import { Button } from '@/components/elements/button';

const Wrapper = styled.div`
    ${tw`text-2xl flex flex-row justify-center items-center`};
`;

export default () => {
    const { search } = useLocation();
    const defaultPage = Number(new URLSearchParams(search).get('page') || '1');
    const [resources, setResources] = useState<Resources>();

    const [page, setPage] = useState(!isNaN(defaultPage) && defaultPage > 0 ? defaultPage : 1);
    const { clearFlashes, clearAndAddHttpError } = useFlash();
    const uuid = useStoreState((state) => state.user.data!.uuid);
    const rootAdmin = useStoreState((state) => state.user.data!.rootAdmin);
    const [showOnlyAdmin, setShowOnlyAdmin] = usePersistedState(`${uuid}:show_all_servers`, false);

    const { data: servers, error } = useSWR<PaginatedResult<Server>>(
        ['/api/client/servers', showOnlyAdmin && rootAdmin, page],
        () => getServers({ page, type: showOnlyAdmin && rootAdmin ? 'admin' : undefined })
    );

    useEffect(() => {
        if (!servers) return;
        if (servers.pagination.currentPage > 1 && !servers.items.length) {
            setPage(1);
        }
    }, [servers?.pagination.currentPage]);

    useEffect(() => {
        // Don't use react-router to handle changing this part of the URL, otherwise it
        // triggers a needless re-render. We just want to track this in the URL incase the
        // user refreshes the page.
        window.history.replaceState(null, document.title, `/${page <= 1 ? '' : `?page=${page}`}`);
    }, [page]);

    useEffect(() => {
        if (error) clearAndAddHttpError({ key: 'dashboard', error });
        if (!error) clearFlashes('dashboard');
    }, [error]);


    useEffect(() => {
        getResources().then((resources) => setResources(resources));
    }, []);

    if (!resources) return <Spinner size={'large'} centered />;

    return (
        <PageContentBlock title={'Dashboard'} css={tw`mt-4 sm:mt-10`} showFlashKey={'dashboard' || 'store:create'}>
            <StoreContainer className={'j-right lg:grid lg:grid-cols-3 my-10'}>
                <TitledGreyBox title={'Total CPU'} className={'mt-8 sm:mt-0'}>
                    <Wrapper>
                        <Icon.Cpu className={'mr-2'} /> {resources.cpu}%
                    </Wrapper>
                </TitledGreyBox>
                <TitledGreyBox title={'Total RAM'} className={'mt-8 sm:mt-0 sm:ml-8'}>
                    <Wrapper>
                        <Icon.PieChart className={'mr-2'} /> {megabytesToHuman(resources.memory)}
                    </Wrapper>
                </TitledGreyBox>
                <TitledGreyBox title={'Total Disk'} className={'mt-8 sm:mt-0 sm:ml-8'}>
                    <Wrapper>
                        <Icon.HardDrive className={'mr-2'} /> {megabytesToHuman(resources.disk)}
                    </Wrapper>
                </TitledGreyBox>
            </StoreContainer>
            <StoreContainer className={'j-left lg:grid lg:grid-cols-4 my-10'}>
                <TitledGreyBox title={'Total Slots'} className={'mt-8 sm:mt-0'}>
                    <Wrapper>
                        <Icon.Server className={'mr-2'} /> {resources.slots}
                    </Wrapper>
                </TitledGreyBox>
                <TitledGreyBox title={'Total Ports'} className={'mt-8 sm:mt-0 sm:ml-8'}>
                    <Wrapper>
                        <Icon.Share2 className={'mr-2'} /> {resources.ports}
                    </Wrapper>
                </TitledGreyBox>
                <TitledGreyBox title={'Total Backups'} className={'mt-8 sm:mt-0 sm:ml-8'}>
                    <Wrapper>
                        <Icon.Archive className={'mr-2'} /> {resources.backups}
                    </Wrapper>
                </TitledGreyBox>
                <TitledGreyBox title={'Total Databases'} className={'mt-8 sm:mt-0 sm:ml-8'}>
                    <Wrapper>
                        <Icon.Database className={'mr-2'} /> {resources.databases}
                    </Wrapper>
                </TitledGreyBox>
            </StoreContainer>
            {!servers ? (
                <Spinner centered size={'large'} />
            ) : (
                <Pagination data={servers} onPageSelect={setPage}>
                    {({ items }) =>
                        items.length > 0 ? (
                            <div className={'lg:grid lg:grid-cols-3 gap-4'}>
                                <>
                                    {items.map((server) => (
                                        <ServerRow
                                            key={server.uuid}
                                            server={server}
                                            className={'j-up'}
                                            css={tw`mt-2`}
                                        />
                                    ))}
                                </>
                            </div>
                        ) : (
                          <div className={'text-center mr-10'}>
                             <h1 className={'text-5xl'}>&nbsp;</h1>
                             <h1 className={'text-5xl'}>&nbsp;</h1>
                             <h1 className={'text-5xl'}>No servers found!</h1>
                             <h3 className={'text-2xl mt-2 text-neutral-500'}>
                               Feel free to create one (:
                             </h3>
                          </div>
                        )
                    }
                </Pagination>
            )}
        </PageContentBlock>
    );
};
